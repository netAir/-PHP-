<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-21
 * Time: 下午5:56
 */
//此为CD类为未使用策略模式的例子
class CD
{
    public $title;
    public $band;

    public function __construct(string $title, string $band)
    {
        $this->title = $title;
        $this->band = $band;
    }

    public function getAsXML()
    {
        $doc = new DOMDocument();
        $root = $doc->createElement('CD');
        $doc->appendChild($root);
        $title = $doc->createElement('TITLE', $this->title);
        $doc->appendChild($title);
        $band = $doc->createElement('BAND', $this->band);
        $doc->appendChild($band);

        return $doc->saveXML();
    }
}

//以下为策略模式,相比原本的CD类拓展了以JSON获取信息的方式.
//策略模式更利于功能的拓展,降低了耦合,降低了类的复杂度
class CDUsesStrategy
{
    public $title;
    public $band;

    protected $strategy;

    public function __construct(string $title, string $band)
    {
        $this->title = $title;
        $this->band = $band;
    }

    public function setStrategyObject(Strategy $strategyObject)
    {
        $this->strategy = $strategyObject;
    }

    public function get()
    {
        return $this->strategy->get($this);
    }
}

abstract class Strategy
{
    abstract public function get(CDUsesStrategy $cd);
}

class CDAsXMLStrategy extends Strategy
{
    public function get(CDUsesStrategy $cd)
    {
        $doc = new DOMDocument();
        $root = $doc->createElement('CD');
        $doc->appendChild($root);
        $title = $doc->createElement('TITLE', $cd->title);
        $doc->appendChild($title);
        $band = $doc->createElement('BAND', $cd->band);
        $doc->appendChild($band);

        return $doc->saveXML();
    }
}

class CDAsJSONStrategy extends Strategy
{
    public function get(CDUsesStrategy $cd)
    {
        $json['CD']['title'] = $cd->title;
        $json['CD']['band'] = $cd->band;

        return json_encode($json);
    }
}

$cd = new CDUsesStrategy('title', 'band');
$cd->setStrategyObject(new CDAsXMLStrategy());
var_dump($cd->get());

$cd->setStrategyObject(new CDAsJSONStrategy());
var_dump($cd->get());