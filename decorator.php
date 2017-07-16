<?php

/**
 * 装饰器
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-16
 * Time: 下午5:14
 */
class CD
{
    public $trackList = array();

    public function addTrack($track)
    {
        $this->trackList[] = $track;
    }

    public function printTrackList()
    {
        $output = '';

        foreach ($this->trackList as $num => $track) {
            $output .= ($num + 1) . ") $track.\t";
        }

        return $output;
    }
}

class CDTrackDecoratorCaps
{
    private $cd;

    public function __construct(CD $cd)
    {
        $this->cd = $cd;
    }

    public function makeCaps()
    {
        foreach ($this->cd->trackList as &$track) {
            $track = strtoupper($track);
        }
    }
}

$myCD = new CD();
foreach (['aa', 'bb', 'cc'] as $item) {
    $myCD->addTrack($item);
}
var_dump($myCD->printTrackList());

$myCDCaps = new CDTrackDecoratorCaps($myCD);
$myCDCaps->makeCaps();
var_dump($myCD->printTrackList());
