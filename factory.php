<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-17
 * Time: 下午5:53
 */
class NormalCD
{
    public $tracks = [];
    public $band = '';
    public $title = '';

    /**
     * @param string $band
     */
    public function setBand(string $band)
    {
        $this->band = $band;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param array $tracks
     */
    public function setTracks(array $tracks)
    {
        $this->tracks = $tracks;
    }
}

class EnhancedCD
{
    public $tracks = [];
    public $band = '';
    public $title = '';

    public function __construct()
    {
        $this->tracks[] = 'DATA TRACK';
    }

    /**
     * @param string $band
     */
    public function setBand(string $band)
    {
        $this->band = $band;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param array $tracks
     */
    public function setTracks(array $tracks)
    {
        $this->tracks = $tracks;
    }
}

//需要一定的逻辑判断才可确定实例化哪个类时,使用工厂类是最佳选择
class CDFactory
{
    public static function create(string $type)
    {
        $class = ucfirst($type) . 'CD';

        return new $class;
    }
}

$cd = CDFactory::create('normal');