<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-20
 * Time: 下午5:55
 */
class CD
{
    protected $title;
    protected $band;
    protected $dbh;

    protected function connectDB()
    {
        $this->dbh = new PDO('mysql:host=localhost;dbname=test', 'test', '123456');
    }

    public function buy()
    {
        //对数据库进行操作...
    }
}

//当你又多了个数据库的时候,使用此类当做代理从中截断CD类的connectDB操作,并执行自己的操作.
class CDProxy extends CD
{
    protected function connectDB()
    {
        $this->dbh = new PDO('mysql:host=newDbIP;dbname=test', 'test', '654321');
    }
}