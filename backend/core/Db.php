<?php
namespace core;
use PDO;
class Db
{
	/**
	 * Объект PDO
	 *
	 * @var PDO
	 */
	protected $db;

	/**
	 * Экземпляр класса
	 *
	 * @var Db
	 */
	protected static $instance;

	private function __construct($dbHost, $dbUser, $dbPassword, $dbName)
	{
		$this->db = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8', $dbUser, $dbPassword);
	}

	/**
	 * Получить экземпляр PDO
	 *
	 * @return Db
	 */
	public static function getDBO()
	{
		if (self::$instance == null) {
			self::$instance = new Db(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
			self::$instance->setPDOConfig();
		}
		return self::$instance;
	}

	/**
	 * Получить прямой доступ к объекту PDO
	 *
	 * @return PDO
	 */
	public function getPDO()
	{
		return $this->db;
	}

	/**
	 * Установить конфигурацию PDO
	 *
	 * @return void
	 */
	private function setPDOConfig()
	{
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Выполнить запрос query к СУБД
	 *
	 * @param string $sql
	 * @param array $params
	 * @return PDOStatement
	 */
	public function query($sql, $params = [])
	{
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
		return $stmt;
	}

	private function array_any($f, $array)
	{
		foreach ($array as $key => $value) {
			if ($f($value, $key) === true)
				return true;
		}
		return false;
	}

	/**
	 * Выполнить запрос exec к СУБД
	 *
	 * @param string $sql
	 * @param array $params
	 * @return int
	 */
	public function exec($sql, $params = [])
	{
		//аналогия prepare из pdo
		if (count($params) > 0) {
			$isAssoc = $this->array_any(function($value, $key) {
				if (!is_numeric($key))
					return true;
				return false;
			}, $params);
			if ($isAssoc) {
				$search = $params;
				$replace = array_map(function($e) {
					return $this->quote($e);
				}, array_values($params));
				$resultSql = str_replace($search, $replace, $sql);
			} else {
				$resultSql = "";
				$paramIndex = 0;
				foreach (str_split($sql) as $char) {
					if ($char == "?") {
						$resultSql .= $this->quote($params[$paramIndex]);
						$paramIndex++;
					}
					else
						$resultSql .= $char;
				}
			}
		}
		else 
			$resultSql = $sql;

		return $this->db->exec($resultSql);
	}

	/**
	 * Выбрать все записи
	 *
	 * @param string $sql
	 * @param array $params
	 * @param int $fetchStyle
	 * @param string $classNameObject
	 * @return array
	 */
	public function getAll($sql, $params = [], $fetchStyle = PDO::FETCH_ASSOC, $classNameObject = null)
	{
		$result = $this->query($sql, $params);
		$result->setFetchMode($fetchStyle, $classNameObject);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Выбрать одну запись
	 *
	 * @param string $sql
	 * @param array $params
	 * @param int $fetchStyle
	 * @param string $classNameObject
	 * @return mixed
	 */
	public function getFirst($sql, $params = [], $fetchStyle = PDO::FETCH_ASSOC, $classNameObject = null)
	{
		$result = $this->query($sql, $params);
		if ($classNameObject == null)
			$result->setFetchMode($fetchStyle);
		else
			$result->setFetchMode($fetchStyle, $classNameObject);
		return $result->fetch();
	}

	/**
	 * Выбрать столбец
	 *
	 * @param string $sql
	 * @param array $params
	 * @param int $column
	 * @return mixed
	 */
	public function getColumn($sql, $params = [], $column = 0)
	{
		$result = $this->query($sql, $params);
		return $result->fetchColumn($column);
	}

	/**
	 * Получить ID последней вставленной записи
	 *
	 * @return int
	 */
	public function getLastInsertId()
	{
		return $this->db->lastInsertId();
	}

	/**
	 * Экранировать спецсимволы
	 *
	 * @param string $str
	 * @param boolean $isWrap
	 * @return void
	 */
	public function quote($str, $isWrap = true)
	{
		if ($isWrap)
			return $this->db->quote($str);
		else
			return substr($this->db->quote($str), 1, -1);
	}
}
