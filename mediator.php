<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-19
 * Time: 下午4:46
 */
class OldCD
{
    public $band;
    public $title;

    public function save()
    {
        //假装修改了将数据写回到数据库
        var_dump($this);
    }

    public function changeBandName($newName)
    {
        $this->band = $newName;
        $this->save();
    }
}

//为了添加MP3归档类(MP3Archive),并且再更改MP3归档的同时修改CD对象,需要修改原有CD类
abstract class Base
{
    public $band = '';
    public $title = '';

    protected $mediator;

    abstract public function save();

    abstract public function changeBandName($newName);
}

class CD extends Base
{

    public function __construct(MusicContainerMediator $mediator = null)
    {
        $this->mediator = $mediator;
    }

    public function save()
    {
        //还是得假装修改了将数据写回到数据库
        var_dump($this);
    }

    public function changeBandName($newName)
    {
        if (!is_null($this->mediator)) {
            $this->mediator->change($this, ['band' => $newName]);
        }
        $this->band = $newName;
        $this->save();
    }
}

class MP3Archive extends Base
{

    public function __construct(MusicContainerMediator $mediator = null)
    {
        $this->mediator = $mediator;
    }

    public function save()
    {
        //还是得假装修改了将数据写回到数据库
        var_dump($this);
    }

    public function changeBandName($newName)
    {
        if (!is_null($this->mediator)) {
            $this->mediator->change($this, ['band' => $newName]);
        }
        $this->band = $newName;
        $this->save();
    }
}

class MusicContainerMediator
{
    protected $containers = [];

    public function __construct()
    {
        $this->containers[] = 'CD';
        $this->containers[] = 'MP3Archive';
    }

    public function change(Base $originalObject, array $newValue)
    {
        $title = $originalObject->title;
        $band = $originalObject->band;

        foreach ($this->containers as $container) {
            if (!($originalObject instanceof $container)) {
                $object = new $container;
                $object->title = $title;
                $object->band = $band;

                foreach ($newValue as $key => $value) {
                    $object->$key = $value;
                }

                $object->save();
            }
        }
    }
}

$titleFromDB = 'Waste of a Rib';
$bandFromDB = 'Never Again';

$mediator = new MusicContainerMediator();
$cd = new CD($mediator);
$cd->title = $titleFromDB;
$cd->band = $bandFromDB;

$cd->changeBandName('Maybe Once More');