<?php
class NoweAuto {
    protected $model;
    protected $cena;
    protected $kurs;

    public function __construct($model, $cena, $kurs) {
        $this->model = $model;
        $this->cena = $cena;
        $this->kurs = $kurs;
    }

    public function obliczCene() {
        return $this->cena * $this->kurs;
    }
}

class AutoZDodatkami extends NoweAuto {
    private $alarm;
    private $radio;
    private $klimatyzacja;

    public function __construct($model, $cena, $kurs, $alarm, $radio, $klimatyzacja) {
        parent::__construct($model, $cena, $kurs);
        $this->alarm = $alarm;
        $this->radio = $radio;
        $this->klimatyzacja = $klimatyzacja;
    }

    public function obliczCene() {
        $cena = parent::obliczCene();
        $dodatki = $this->alarm + $this->radio + $this->klimatyzacja;
        return $cena + $dodatki * $this->kurs;
    }
}

class Ubezpieczenie extends AutoZDodatkami {
    private $procent;
    private $iloscLat;

    public function __construct($model, $cena, $kurs, $alarm, $radio, $klimatyzacja, $procent, $iloscLat) {
        parent::__construct($model, $cena, $kurs, $alarm, $radio, $klimatyzacja);
        $this->procent = $procent;
        $this->iloscLat = $iloscLat;
    }

    public function obliczCene() {
        $cena = parent::obliczCene();
        $znizka = 1 - ($this->iloscLat * 0.01);
        $ubezpieczenie = $this->procent * $cena * $znizka;
        return $cena + $ubezpieczenie;
    }
}

$model = "Lexus";
$cena = 50000;
$kurs = 4.5;
$alarm = 1000;
$radio = 500;
$klimatyzacja = 2000;
$procent = 0.05;
$iloscLat = 5;
$autoZDodatkami = new AutoZDodatkami($model, $cena, $kurs, $alarm, $radio, $klimatyzacja);
echo "Cena samochodu z dodatkami: ", $autoZDodatkami->obliczCene(), " PLN\n";
$ubezpieczenie = new Ubezpieczenie($model, $cena, $kurs, $alarm, $radio, $klimatyzacja, $procent, $iloscLat);
echo "Cena samochodu z ubezpieczeniem: ", $ubezpieczenie->obliczCene(), " PLN";
?>