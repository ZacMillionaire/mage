<?php

/**
 * Created by PhpStorm.
 * User: scoot
 * Date: 26/12/2014
 * Time: 2:21 PM
 */

require_once("UserManagement.php");
class UserSystem extends Main
{

	function __construct(){
		$this->DatabaseSystem = parent::DatabaseSystem();
		$this->UserManagement = new UserManagement();
	}

	public function RegisterUser($email, $password){

		//echo self::GenerateConfirmationCode();

		foreach (func_get_args() as $key => $value) {
			if(trim($value) == null) {
				return array("error" => "FIELD_NULL");
			}
		}

		if(self::EmailExists($email)){
			return array("error" => "EMAIL_IN_USE");
		}


		$sql = "INSERT INTO `users`(
				`email`,
				`password`,
				`passwordSalt`,
				`confirmationCode`
			) VALUES (
				:email,
				:password,
				:passwordSalt,
				:confirmationCode
			)";
	
		$password = self::HashPassword($password);
		$username = self::ValidateEmail($email);
		$confirmationCode = self::GenerateConfirmationCode();

		$params = array(
			"email" => $email,
			"password" => $password["hash"],
			"passwordSalt" => $password["salt"],
			"confirmationCode" => $confirmationCode
		);

		print_r($params);

		if($this->DatabaseSystem->Insert($sql,$params)) {

			//self::SendConfirmationEmail($email, $confirmationCode);

			return true;
		}
		return false;
	}

	public function LoginUser($email, $password) {

		foreach (func_get_args() as $key => $value) {
			if(trim($value) == null) {
				return array("error" => "FIELD_NULL");
			}
		}

		if(!self::EmailExists($email)){
			return array("error" => "EMAIL_NOT_EXIST");
		}

		$sql = "SELECT * FROM `users` WHERE `email` = :email";
		$params = array(
			"email" => $email
		);

		$result = $this->DatabaseSystem->Query($sql,$params);

		$givenPassword = self::CheckPassword($password, $result[0]["passwordSalt"]);

		if($givenPassword === $result[0]["password"]) {

			if(self::GenerateCookie($result[0]["email"])) {
				return true;
			} else {
				return array("error" => "ROGUE_WIZARD");
			}

		} else {
			return array("error" => "PASSWORD_INCORRECT");
		}

	}

	private function CheckInviteCodeClaimed($inviteCode){

		$sql = "SELECT `claimed` FROM `inviteCodes` WHERE `inviteCode` = :inviteCode LIMIT 1;";
		$params = array("inviteCode" => $inviteCode);
		$result = $this->DatabaseSystem->Query($sql,$params);

		if(isset($result[0])) {

			$sql = "UPDATE `inviteCodes` SET `claimed` = 1 WHERE `inviteCode` = :inviteCode;";
			$params = array("inviteCode" => $inviteCode);
			$this->DatabaseSystem->Query($sql,$params);

			return (bool)$result[0]["claimed"];
		}
		return false;

	}

	private function EmailExists($email){

		$sql = "SELECT `email` FROM `users` WHERE `email` = :email LIMIT 1;";
		$params = array("email"=>$email);
		$result = $this->DatabaseSystem->Query($sql,$params);

		if(isset($result[0])){
			return true;
		}
		return false;
	}

	private function ValidateEmail($email) {

		return $email;

	}

	private function HashPassword($password) {

		$salt = hash("sha512",mt_rand());
		$passwordTmp = hash("sha512",$password);
		$passwordHash = hash("sha512",$salt.$passwordTmp);

		return array("hash" => $passwordHash, "salt" => $salt);

	}

	private function CheckPassword($password, $passwordSalt) {

		$passwordTmp = hash("sha512",$password);
		$passwordHashed = hash("sha512",$passwordSalt.$passwordTmp);

		return $passwordHashed;

	}

	private function GenerateCookie($email){

		$SystemSettings = parent::SystemSettings();

		$cookieHash = hash("sha512",time().$email);

		$currTime = time();

		$sql = "REPLACE INTO `users_loggedin`
				(
					`userID`,
					`cookieHash`,
					`login_timestamp`
				) VALUES (
					(
						SELECT `userID`
						FROM `users`
						WHERE `email` = :email
					),
					:cookieHash,
					:currTime
				);";

		$params = array(
			"email" => $email,
			"cookieHash" => $cookieHash,
			"currTime" => date("Y-m-d h:i:s",$currTime)
		);

		$query = $this->DatabaseSystem->Insert($sql,$params);

		if($query) {

			// 1 week from right now. (curr_time + (day in seconds * days))
			$timeToExpire = $currTime + (86400 * 7);

			setcookie(
				"loginHash",
				$cookieHash,
				$timeToExpire,
				$SystemSettings["dir"],
				$SystemSettings["host"]
			);

			return true;

		} else {
			return false;

		} // End if(successful query)


	}

	private function SendConfirmationEmail($email, $confirmationCode){

		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html; charset=iso-8859-1";
		$headers[] = "From: Registration System <noreply>";
		$headers[] = "Subject: Confirm Email for QUT CODE Skills Profile";
		$headers[] = "X-Mailer: PHP/".phpversion();

		$subject = null;

		$body = "<a href=\"http://jotunga.com/QUTCode/Skills Profile/confirm-email/".$confirmationCode."\">Click to confirm email</a>";

		mail($email, $subject, $body, implode("\r\n", $headers));

	}

	private function GenerateConfirmationCode(){

		$confirmationCode = null;
		$stupidDict = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890_-";

		for($i = 0; $i != 50; $i++){
			$confirmationCode .= $stupidDict[rand(0,(strlen($stupidDict)-1))];
		}

		return $confirmationCode;
	}

	// This confirms the confirmation code
	public function ConfirmConfirmationCode($confirmationCode) {

		$sql = "SELECT `confirmationCode`,`email` FROM `users` WHERE `confirmationCode` = :confirmationCode AND `verified` = 0";
		$params = array("confirmationCode" => $confirmationCode);

		$result = $this->DatabaseSystem->Query($sql,$params);

		if(!$result) {
			return false;
		}

		$sql = "UPDATE `users` SET `verified` = 1, `email` = :email, `confirmationCode` = null WHERE `confirmationCode` = :confirmationCode;";
		$params = array(
			"confirmationCode" => $confirmationCode,
			"email" => hash("sha512",$result[0]["email"])
		);

		$this->DatabaseSystem->Query($sql,$params);
		return true;

	}

}

?>