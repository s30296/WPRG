<?php
interface Animal {
    function makeSound();
    function eat();
}

class Dog implements Animal {

    function makeSound() {
        return "Woof!";
    }

    function eat() {
        return "The dog is eating.";
    }
}

$dog = new Dog();

echo $dog->makeSound() . "\n";
echo $dog->eat() . "\n";
?>