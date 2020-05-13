<?php

namespace App\Core\Database;

use PDO;

class QueryBuilder
{
	/**
	 * The PDO instance.
	 *
	 * @var PDO
	 */
	protected $pdo;

	/**
	 * Create a new QueryBuilder instance.
	 *
	 * @param PDO $pdo
	 */
	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	const SHOW_BY_DEFAULT = 4;

	public function selectAllWhere($table, $where)
	{
		$statement = $this->pdo->prepare("select * from {$table} where {$where}");
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_CLASS);
	}

	/**
	 * Select all records from a database table.
	 *
	 * @param string $table
	 *
	 * @return array
	 */
	public function selectAll($table)
	{
		$statement = $this->pdo->prepare("select * from {$table}");
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_CLASS);
	}

	/**
	 * Возвращает поисковую графу по заданому параметру
	 *
	 * @param строка $table
	 * @param строка $search
	 * @param строка $param
	 *
	 * @return array
	 */
	public function selectAllParam($table, $search, $param)
    {
		$statement = $this->pdo->prepare("select {$search} from {$table} where {$param}");
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_CLASS);
	}

	/**
	 * Select one record from a database table.
	 *
	 * @param string $table
	 * @param string $param
	 * @param string $value
	 *
	 * @return array
	 */
	public function selectOne($table, $param, $value)
	{
		$statement = $this->pdo->prepare("select * from " . '`' . "{$table}".'` '. "where ".'`'."{$param}". '`=\'' . "{$value}'");
		$statement->execute();
		return $statement->fetchObject();
	}

	public function selectAvtorFoto($fotoId)
    {
		$statement = $this->pdo->prepare("select U.user_name AS USERSNAME FROM foto AS F LEFT JOIN users AS U ON F.user_id = U.id AND f.id = {$fotoId}");
		$statement->execute();
		return $statement->fetchObject();
	}

	/**
	 * Update one record from a database table.
	 *
	 * @param string $table
	 * @param array $data
	 *
	 */
	public function update($table, $id, $data)
	{
		$sqlString = "UPDATE {$table} SET ";
		$counter = 0;
		foreach ($data as $param => $value) {
			if ($counter){
				$sqlString .= ", ";
			}
			$sqlString .= "$param = ".'"'."{$value}".'"';
			$counter++;
		}
		$sqlString .= " WHERE id = ". $id;
		$data['id'] = $id;
		$statement = $this->pdo->prepare($sqlString);
		$statement->execute($data);
	}

	public function update3($table, $id, $data)
	{
		$sqlString = "UPDATE {$table} SET ";
		$counter = 0;
		foreach ($data as $param => $value) {
			if ($counter){
				$sqlString .= ", ";
			}
			$sqlString .= "$param = ".'"'."{$value}".'"';
			$counter++;
		}
		$sqlString .= " WHERE user_id = ". $id;
		$data['id'] = $id;
		$statement = $this->pdo->prepare($sqlString);
		$statement->execute($data);
	}

	public function update2($table, $id, $data)
	{
		$sqlString = "UPDATE {$table} SET ";
		$counter = 0;
		foreach ($data as $param => $value) {
			if ($counter){
				$sqlString .= ", ";
			}
			$sqlString .= "$param = ".'"'."{$value}".'"';
			$counter++;
		}
		$sqlString .= " WHERE id_user = ". $id;
		$data['id'] = $id;
		$statement = $this->pdo->prepare($sqlString);
		$statement->execute($data);
	}

	public function updateStatus($id, $chatId, $userId)
    {
		$sqlString = "UPDATE `massege` SET `status` = 1 WHERE `id` <= {$id} AND `chat_id` = {$chatId} AND `user_id` = {$userId}";
		$statement = $this->pdo->prepare($sqlString);
		$statement->execute();
	}

	/**
	 * Подсчёт количества елементов в таблице
	 *
	 * @param  string $table
	 * @param  string $id
	 * @return int $count
	 */
	public function count($table, $name)
    {
		$sqlString = "SELECT COUNT({$name}) AS count FROM {$table}";
		$statement = $this->pdo->query($sqlString);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		return ($row['count']);

	}

	/**
	 * Update activ accaunt from a database table.
	 *
	 * @param string $table
	 * @param array $data
	 *
	 */
	public function updateActiv($hash_email)
	{
		$value = "hash_email";
		$sqlString = "UPDATE users SET act_email = 1 WHERE " .'"'. "{$hash_email}".'"'. " = {$value}";
		$statement = $this->pdo->prepare($sqlString);
		$statement->execute();
	}

    public function updateActiv42($email)
    {
        $sqlString = "UPDATE users SET act_email = 1 WHERE email = '". $email . "'";
        $statement = $this->pdo->prepare($sqlString);
        $statement->execute();
    }

	public function updatePassword($id, $email, $password)
    {
		$password = hash ( 'whirlpool' , $password );
		$sqlString = "UPDATE `users` SET `password` =".' "'."{$password}".'"'." WHERE `id` = ".'"'."{$id}".'"'." AND `email` = ".'"'."{$email}".'"';
		$statement = $this->pdo->prepare($sqlString);
		$statement->execute();
	}

	public function updateLikeActiv($status, $userId, $fotoId)
    {
		$sqlString = "UPDATE like_photo SET status = {$status} WHERE user_id = {$userId} AND foto_id = {$fotoId}";
		$statement = $this->pdo->prepare($sqlString);
		$statement->execute();
	}

	/**
	 * Delete one record from a database table.
	 *
	 * @param string $table
	 * @param string $id
	 *
	 */
	public function delete($table, $id)
	{
		$sql = "DELETE FROM {$table} WHERE id =  :id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute(['id' => $id]);
	}

	public function delete2($table, $id)
	{
		$sql = "DELETE FROM {$table} WHERE foto_id =  :id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute(['id' => $id]);
	}

	public function deleteUniversal($table, $param)
    {
        $sql = "DELETE FROM {$table} WHERE {$param}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
    }

	public function delete_foto($table, $foto)
	{
		$sql = "DELETE FROM {$table} WHERE img =  :foto";
		$statement = $this->pdo->prepare($sql);
		$statement->execute(['foto' => $foto]);
	}

	/**
	 * Insert a record into a table.
	 *
	 * @param  string $table
	 * @param  array  $parameters
	 */
	public function insert($table, $parameters)
	{
		$sql = sprintf(
			'insert into %s (%s) values (%s)',
			$table,
			implode(', ', array_keys($parameters)),
			':' . implode(', :', array_keys($parameters))
		);
		$statement = $this->pdo->prepare($sql);
		$statement->execute($parameters);
	}

	public function insertMassage($chatId, $myId, $text, $status)
    {
		$sql = "INSERT INTO `massege`( `chat_id`, `user_id`, `text`, `time`, `date`, `status`)
 			VALUES ({$chatId}, {$myId}, \"{$text}\", CURTIME(), CURDATE(),{$status})";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
	}

    public function selectLimit($table)
    {
        $sql = "SELECT * FROM " . $table;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectDistinctYear($table)
    {
        $sql = "select distinct(film_year) from ". $table . " order by film_year DESC;";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectDistinctIMDB($table)
    {
        $sql = "select distinct(imdbRating) from ". $table . " order by imdbRating DESC";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectSearchFilm($name, $year, $imdb, $sort)
    {
        $name = "%" . $name . "%";
        $sql = 'select * from film_info where original_title like :name and title like :name '.
            ' and film_year = :year and imdbRating = :imdb order by title ' . $sort . ';';

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":name", $name, PDO::PARAM_STR);
        $statement->bindValue(":year", $year, PDO::PARAM_STR);
        $statement->bindValue(":imdb", $imdb, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
