<?php
class Product {
    private $name;
    private $price;
    private $quantity;

    public function __construct($name, $price, $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function __toString() {
        return "Product: $this->name, Price: $this->price, Quantity: $this->quantity";
    }
}

class Cart {
    private $products;

    public function __construct() {
        $this->products = [];
    }

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function removeProduct(Product $product) {
        for ($i = 0; $i < count($this->products); $i++) {
            if ($this->products[$i]->getName() == $product->getName()) {
                unset($this->products[$i]);
                $this->products = array_values($this->products);
                return true;
            }
        }
        return false;
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice() * $product->getQuantity();
        }
        return $total;
    }

    public function __toString() {
        $output = "Products in cart:\n";
        for ($i = 0; $i < count($this->products); $i++) {
            $output .= $this->products[$i] . "\n";
        }
        $output .= "Total price: " . $this->getTotal();
        return $output;
    }
}

$product1 = new Product("Laptop", 1500, 1);
$product2 = new Product("Mouse", 50, 2);
$cart = new Cart();
$cart->addProduct($product1);
$cart->addProduct($product2);
echo $cart;
$cart->removeProduct($product1);
echo "\n\n";
echo $cart;
?>