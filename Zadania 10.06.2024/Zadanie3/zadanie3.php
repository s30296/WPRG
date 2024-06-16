<?php
trait A {
    public function smallTalk() {
        echo 'a';
    }
    public function bigTalk() {
        echo 'A';
    }
}
trait B {
    public function smallTalk() {
        echo 'b';
    }
    public function bigTalk() {
        echo 'B';
    }
}

class AB {
    use A, B {
        A::bigTalk insteadof B;
        A::smallTalk insteadof B;
        B::bigTalk as bigTalkB;
        B::smallTalk as smallTalkB;
    }
}

$ab = new AB();

echo $ab->bigTalk() . "\n";
echo $ab->smallTalk() . "\n";
echo $ab->bigTalkB() . "\n";
echo $ab->smallTalkB() . "\n";
?>