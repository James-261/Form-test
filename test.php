<?php



class Fruit {
  public $name;
  public $color;

  function __construct($name, $color) {
    $this->setName($name);
    $this->setColor($color);
  }

  function getColor() {
    return $this->color;
  }

  function getName() {
      return $this->name;
    }

  protected function setName(String $name) {
      $this->name = $name;
  }

  protected function setColor(String $color) {
      $this->color = $color;
  }
}

class Strawberry extends Fruit {

  function __construct($name, $color) {
    $this->setName($name);
    $this->setColor($color);

    if (strtolower($color) !== 'red') {
      throw new Exception("Strawberries must be red");
    }
  }

  public function getDetails() {
    echo "Color: ".$this->getColor()." name:".$this->getName();
  }

}

// $apple = new Fruit("Apple", "Green");
$strawberry = new Strawberry("Strawberry", "Red");
// $strawberry->getDetails();
// $strawberry->setName("Cheese");
// $strawberry->setColor("Orange");
// $strawberry->getDetails();





























































?>
