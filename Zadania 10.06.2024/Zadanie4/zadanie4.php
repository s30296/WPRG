<?php
trait Speed {
    public $speed;

    function increaseSpeed($speed) {
        $this->speed = $this->speed + $speed;
    }

    function decreaseSpeed($speed) {
        if ($this->speed > 0) {
            $this->speed = $this->speed - $speed;
        }
    }
}

class Car {
    use Speed;

    function start() {
        $this->speed = 0;
        $this->increaseSpeed(10);
    }
}

$car = new Car();

$car->start();
echo "Predkosc: " . $car->speed . "\n";

$car->increaseSpeed(50);
echo "Predkosc: " . $car->speed . "\n";

$car->decreaseSpeed(20);
echo "Predkosc: " . $car->speed . "\n";
?>