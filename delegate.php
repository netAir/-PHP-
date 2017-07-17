<?php
/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-17
 * Time: 下午3:51
 */
//未使用委托模式时
class Playlist
{
    private $songs = [];

    public function addSong($location, $title)
    {
        $song = ['location' => $location, 'title' => $title];
        $this->songs[] = $song;
    }

    public function getM3U()
    {
        $m3u = '';
        /*
         * 生成M3U格式播放列表文本字符串
         * ......
         */
        return $m3u;
    }

    public function getPLS()
    {
        $pls = '';
        /*
         * 生成PLS格式播放列表文本字符串
         * ......
         */
        return $pls;
    }
}

$playlist = new Playlist();
$playlist->addSong('/song/1.mp3', 'aaa');
$playlist->addSong('/song/2.mp3', 'bbb');

//不使用委托模式,当分支很多时下面的if分支结构代码与上面的Playlist类的代码会很臃肿.
$type = 'PLS';
if ($type === 'PLS') {
    $playlistContent = $playlist->getPLS();
} else {
    $playlistContent = $playlist->getM3U();
}


//使用委托模式
class NewPlaylist
{
    private $songs = [];
    private $typeObject;

    public function __construct($type)
    {
        $object = $type . 'PlaylistDelegate';
        $this->typeObject = new $object;
    }

    public function addSong($location, $title)
    {
        $song = ['location' => $location, 'title' => $title];
        $this->songs[] = $song;
    }

    public function getPlaylist()
    {
        return $this->typeObject->getPlaylist($this->songs);
    }
}

class M3UPlaylistDelegate
{
    public function getPlaylist($songs)
    {
        $m3u = '';
        /*
         * 生成M3U格式播放列表文本字符串
         * ......
         */
        return $m3u;
    }
}

class PLSPlayListDelegate
{
    public function getPlaylist($songs)
    {
        $pls = '';
        /*
         * 生成PLS格式播放列表文本字符串
         * ......
         */
        return $pls;
    }
}

$type = 'PLS';
$playlist = new NewPlaylist($type);
$playlistContent=$playlist->getPlaylist();
