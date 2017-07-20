<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-20
 * Time: 下午3:54
 */
class CD
{
    public $title;
    public $band;
    protected $observers = [];

    public function __construct(string $title, string $band)
    {
        $this->title = $title;
        $this->band = $band;
    }

    public function attachObserver(string $type, BuyCDNotifyStreamObserver $observer)
    {
        $this->observers[$type][] = $observer;
    }

    public function notifyObserver(string $type)
    {
        if (!empty($this->observers[$type])) {
            foreach ($this->observers[$type] as $observer) {
                $observer->update($this);
            }
        }
    }

    public function buy()
    {
        $this->notifyObserver('purchased');
    }
}

class BuyCDNotifyStreamObserver
{
    public function update(CD $cd)
    {
        $activity = "This CD named $cd->title by $cd->band was just purchased.";
        ActivityStream::addNewItem($activity);
    }
}

class ActivityStream
{
    //这是一个,当被观察者执行了某一动作后,所有观察者都需要去执行的一个动作
    public static function addNewItem(string $item)
    {
        //什么什么的
        var_dump($item);
    }
}

$title = 'title';
$band = 'band';
$cd = new CD($title, $band);
$observer = new BuyCDNotifyStreamObserver();
$cd->attachObserver('purchased', $observer);

$cd->buy();