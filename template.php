<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-22
 * Time: 上午10:40
 */
//模板模式,由最终方法定义大致过程的框架,再由各个子类完成其子方法的具体内容.
abstract class SaleItemTemplate
{
    public $price = 0;

    final public function setPriceAdjustments()
    {
        $this->price += $this->taxAddition();
        $this->price += $this->oversizedAddition();
    }


    protected function oversizedAddition()
    {
        return 0;
    }

    abstract protected function taxAddition();
}

class CD extends SaleItemTemplate
{
    public $band;
    public $title;

    public function __construct(string $band, string $title, float $price)
    {
        $this->band = $band;
        $this->title = $title;
        $this->price = $price;
    }

    protected function taxAddition()
    {
        return round($this->price * .05, 2);
    }
}

class BandEndorsedCaseOfCereal extends SaleItemTemplate
{
    public $band;

    public function __construct(string $band, string $price)
    {
        $this->band = $band;
        $this->price = $price;
    }

    protected function taxAddition()
    {
        return 0;
    }

    protected function oversizedAddition()
    {
        return round($this->price * .20, 2);
    }
}

$externalTitle = 'title';
$externalBand = 'band';
$externalCDPrice = 12.99;
$externalCerealPrice = 90;

$cd = new CD($externalBand, $externalTitle, $externalCDPrice);
$cd->setPriceAdjustments();
var_dump($cd->price);

$cereal = new BandEndorsedCaseOfCereal($externalBand, $externalCerealPrice);
$cereal->setPriceAdjustments();
var_dump($cereal->price);
