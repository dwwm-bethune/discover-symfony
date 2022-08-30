<?php

namespace App;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Product
{
    #[NotBlank()]
    public $name;

    #[NotBlank(), Length(min: 2, max: 6)]
    public $description;
}
