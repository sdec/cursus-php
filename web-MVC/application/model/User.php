<?php
class Vehicle
{
    private $username;
    private $accesslevel;
    private $firstname;
    private $lastname;

    public function __construct($color = 'blauw', $brand = 'audi')
    {
        $this->setColor($color);
        $this->setBrand($brand);
    }

    public function __toString()
    {
        return 'de gebruiker met de kleur ' . $this->getColor() . ' en het merk ' . $this->getBrand();
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getBrand()
    {
        return $this->brand;
    }
}

?>