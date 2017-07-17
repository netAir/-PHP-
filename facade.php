<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-17
 * Time: 下午4:46
 */
class CD
{
    public $tracks = [];
    public $band = '';
    public $title = '';

    public function __construct(string $title, string $band, array $tracks)
    {
        $this->title = $title;
        $this->band = $band;
        $this->tracks = $tracks;
    }
}

//下面两个类负责处理CD类以获取最终所需信息格式
class CDUpperCase
{
    public static function makeString(CD $cd, string $type)
    {
        $cd->$type = strtoupper($cd->$type);
    }

    public static function makeArray(CD $cd, string $type)
    {
        $cd->$type = array_map('strtoupper', $cd->$type);
    }
}

class CDMakeXML
{
    public static function create(CD $cd)
    {
        $doc = new DOMDocument();
        /*
         * 根据$cd生成相应XML字符串
         * ......
         */
        return $doc->saveXML();
    }
}

//使用装饰器将生成最终结果(调用以上两类中的各个方法)的过程进行包装
class WebServiceFacade
{
    public static function makeXMLCall(CD $cd)
    {
        CDUpperCase::makeString($cd, 'title');
        CDUpperCase::makeString($cd, 'band');
        CDUpperCase::makeArray($cd, 'tracks');

        $xml = CDMakeXML::create($cd);

        return $xml;
    }
}

$tracksFromExternalSource = ['a', 'b', 'c'];
$title = 'title';
$band = 'band';
$cd = new CD($title, $band, $tracksFromExternalSource);

print WebServiceFacade::makeXMLCall($cd);