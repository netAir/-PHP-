<?php
/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-20
 * Time: 下午5:24
 */
/*
 * 原型模式是创建型模式的一种,其特点在于通过“复制”一个已经存在的实例来返回新的实例,而不是新建实例。被复制的实例就是我们所称的“原型”，这个原
 * 型是可定制的。原型模式多用于创建复杂的或者耗时的实例，因为这种情况下，复制一个已经存在的实例使程序运行更高效；或者创建值相等，只是命名不一
 * 样的同类数据。(来自维基)
 */

class CD
{
    public $title;
    public $band;
    public $trackList = [];

    public function __construct(int $id)
    {
        //假装从数据库拿到了id为$id的数据,哎..太懒
        $this->title = 'title' . $id;
        $this->band = 'band' . $id;
    }

    public function buy()
    {
        var_dump($this);
    }
}

class MixtapeCD extends CD
{
    public function __clone()
    {
        $this->title = 'Mixtape';
    }
}

$externalPurchaseInfoBandID = 12;
$bandMixProto = new MixtapeCD($externalPurchaseInfoBandID);
$externalPurchaseInfo = [];
$externalPurchaseInfo[] = ['brrr', 'goodbye'];
$externalPurchaseInfo[] = ['what it means', 'brrr'];

foreach ($externalPurchaseInfo as $mixed) {
    $cd = clone $bandMixProto;
    $cd->trackList = $mixed;
    $cd->buy();
}