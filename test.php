<?php



class Fruit {
  public $name;
  public $color;

  function __construct($name, $color) {
    $this->name = $name;
    $this->color = $color;
  }
}

class Strawberry extends Fruit {
  public function message() {
    echo "hi" ;
  }
}

$apple = new Fruit("Apple");
$strawberry = new Strawberry("Strawberry", "Red");
$strawberry->message();




























































?>
