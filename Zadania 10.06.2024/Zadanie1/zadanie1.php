<?php
interface Volume {
    function increaseVolume();
    function decreaseVolume();
}

interface Playable {
    function play();
    function stop();
}

class MusicPlayer implements Volume, Playable {
    public $volume = 10;
    public $status = false;

    function increaseVolume() {
        $this->volume = $this->volume + 1;
    }

    function decreaseVolume() {
        if ($this->volume > 0) {
            $this->volume = $this->volume - 1;
        }
    }

    function play() {
        $this->status = true;
    }

    function stop() {
        $this->status = false;
    }

    function getVolume() {
        return $this->volume;
    }

    function isPlaying() {
        return $this->status;
    }
}

$musicPlayer = new MusicPlayer();

$musicPlayer->increaseVolume();
echo "Glosnosc: " . $musicPlayer->getVolume() . "\n";

$musicPlayer->decreaseVolume();
echo "Glosnosc: " . $musicPlayer->getVolume() . "\n";

$musicPlayer->play();
echo "Czy odtwarza: ";
if ($musicPlayer->isPlaying()) {
    echo "tak\n";
} else {
    echo "nie\n";
}

$musicPlayer->stop();
echo "Czy odtwarza: ";
if ($musicPlayer->isPlaying()) {
    echo "tak\n";
} else {
    echo "nie\n";
}
?>