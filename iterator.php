<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-18
 * Time: 下午5:11
 */
class CD
{
    public $band = '';
    public $title = '';
    public $trackList = [];

    public function __construct(string $band, string $title)
    {
        $this->title = $title;
        $this->band = $band;
    }

    public function addTrack(string $track)
    {
        $this->trackList[] = $track;
    }
}

class CDSearchByBandIterator implements Iterator
{
    private $CDs = [];
    private $valid = false;

    public function __construct(string $bandName)
    {
        //从数据库拿到了一些CD的数据
        $cd = new CD('band', 'title');
        $cd->addTrack('track1');
        $cd->addTrack('track2');

        $this->CDs[] = $cd;
    }

    public function next()
    {
        $this->valid = (next($this->CDs) === false) ? false : true;
    }

    public function rewind()
    {
        $this->valid = (reset($this->CDs) === false) ? false : true;
    }

    public function valid()
    {
        return $this->valid;
    }

    public function current(): CD
    {
        return current($this->CDs);
    }

    public function key()
    {
        return key($this->CDs);
    }
}

$cds = new CDSearchByBandIterator('aaa');
foreach ($cds as $cd) {
    var_dump($cd->band, $cd->title, $cd->trackList);
}