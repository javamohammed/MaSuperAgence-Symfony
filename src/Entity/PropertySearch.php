<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{
    
    private $maxPrice;

    /**
     *@var int|null
     *@Assert\Range(min=10,max=400)
    */
    private $minSurface;


    /**  Getter and Setter Max Price */

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }
     public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**  Getter and Setter Min Surface */

    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

     public function setMinSurface(int $minSurface): self
    {
        $this->minSurface = $minSurface;

        return $this;
    }


}






?>