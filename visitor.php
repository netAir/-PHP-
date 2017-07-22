<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-22
 * Time: 下午2:33
 */
class CD
{
    public $title;
    public $band;
    public $price;

    public function __construct(string $title, string $band, float $price)
    {
        $this->title = $title;
        $this->band = $band;
        $this->price = $price;
    }

    public function buy()
    {
        //假装这里会做些什么..
    }

    public function acceptVisitor($visitor)
    {
        $visitor->visitCD($this);
    }
}

abstract class Visitor
{
    abstract public function visitCD(CD $cd);
}

class CDVisitorLogPurchase extends Visitor
{
    public function visitCD(CD $cd)
    {
        $logline = "$cd->band,$cd->title,$cd->price";
        $logline .= "at " . date('r') . "\n";

        file_put_contents('purchases.log', $logline, FILE_APPEND);
    }
}

class CDVisitorPopulateDiscountList extends Visitor
{
    public function visitCD(CD $cd)
    {
        if ($cd->price < 10) {
            $this->populateDiscountList($cd);
        }
    }

    protected function populateDiscountList(CD $cd)
    {
        //又假装这里会做些什么..
    }
}

$cd = new CD('title', 'band', 9.99);
$cd->buy();

$cd->acceptVisitor(new CDVisitorLogPurchase());
$cd->acceptVisitor(new CDVisitorPopulateDiscountList());