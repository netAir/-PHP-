<?php

/**
 * 数据库访问对象设计模式
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-15
 * Time: 下午3:32
 */
define('DB_DSN', 'mysql:host=localhost;dbname=test');
define('DB_USERNAME', 'test');
define('DB_PASSWD', '123456');

abstract class BaseDAO
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWD);
    }

    public function fetch($value, $key = null)
    {
        if (is_null($key)) {
            $key = $this->primaryKey;
        }

        $sql = "SELECT * FROM $this->tableName WHERE $key=:value";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function update(array $keyedArray)
    {
        $sql = "UPDATE $this->tableName SET ";
        $updates = array();
        foreach (array_keys($keyedArray) as $column) {
            $updates[] = "$column=:$column ";
        }
        $sql .= implode(',', $updates);
        $sql .= "WHERE $this->primaryKey=:key";

        $stmt = $this->dbh->prepare($sql);
        foreach ($keyedArray as $column => $value) {
            $column = ':' . $column;
            $stmt->bindValue($column, $value);
        }
        $stmt->bindParam(':key', $keyedArray[$this->primaryKey]);
        $stmt->execute();
    }
}

/*
 * 子类指向用户表
 */

class UserDAO extends BaseDAO
{
    protected $primaryKey = 'id';
    protected $tableName = 'userTable';

    public function getUserByName(string $name)
    {
        return $this->fetch($name, 'name');
    }

    public function setUserByName(array $keyedArray)
    {
        $this->update($keyedArray);
    }
}

$userDAO = new UserDAO();

print_r($userDAO->getUserByName('aaa'));
$userDAO->setUserByName(['id' => 2, 'name' => 'ddd']);
/*
+----+------+
| id | name |
+----+------+
|  1 | aaa  |
|  2 | ddd  |
+----+------+
*/