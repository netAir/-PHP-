<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-21
 * Time: 下午4:14
 */
class InventoryConnection
{
    protected static $instance;

    protected $dbh;

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    protected function __construct()
    {
        $this->dbh = new PDO('mysql:host=localhost;dbname=test', 'test', '123456');
        var_dump('执行链接数据库操作');
    }

    public function updateQuantity($band, $title, $number)
    {
        //......
    }
}

class CD
{
    protected $title;
    protected $band;

    public function __construct($title, $band)
    {
        $this->title = $title;
        $this->band = $band;
    }

    public function buy()
    {
        $inventory = InventoryConnection::getInstance();

        $inventory->updateQuantity($this->band, $this->title, -1);

    }
}

$boughtCDs = [
    ['band' => 'band1', 'title' => 'title1'],
    ['band' => 'band2', 'title' => 'title2']
];

foreach ($boughtCDs as $boughtCD) {
    $cd = new CD($boughtCD['title'], $boughtCD['band']);
    $cd->buy();
}
//两次购买操作只会执行一次数据库的连接