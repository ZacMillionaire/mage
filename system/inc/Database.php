<?php

class Database
{

	protected $database;


	private static $pdoAttributes = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_EMULATE_PREPARES => false
	);


	public function __construct($host, $database, $user, $password)
	{

		$this->database = new PDO("mysql:host=" . $host . ";dbname=" . $database, $user, $password);

		foreach (self::$pdoAttributes as $attribute => $value) {
			$this->database->setAttribute($attribute, $value);
		}
	}


	public function Query($query, $params)
	{

		try {

			$queryExec = $this->database->prepare($query);
			$queryExec->execute($params);
			$row = $queryExec->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch (PDOException $ex) {

			return false;
			//return "Query Failed. ".$ex->getMessage();
		}

	}


	public function Delete($query, $params)
	{

		try {

			$queryExec = $this->database->prepare($query);
			$queryExec->execute($params);
		} catch (PDOException $ex) {
			return false;
			//return "Query Failed. ".$ex->getMessage();
		}
		return true;

	}


	public function Insert($query, $params)
	{

		try {

			$queryExec = $this->database->prepare($query);
			$queryExec->execute($params);
		} catch (PDOException $ex) {
			return false;
			// return "Query Failed. ".$ex->getMessage();
		}
		return true;
	}


	public function Update($query, $params)
	{

		try {

			$queryExec = $this->database->prepare($query);
			$queryExec->execute($params);
		} catch (PDOException $ex) {

			return false;
			// return "Query Failed. ".$ex->getMessage();
		}
		return true;
	}


	public function Close()
	{

		$this->database = null;
	}

}

?>