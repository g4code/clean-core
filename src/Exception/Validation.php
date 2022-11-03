<?php

namespace G4\CleanCore\Exception;

class Validation extends \Exception
{
    protected $meta;

    protected $name;

    protected $value;

    public function __construct($name, $value, $meta)
    {
        $this->name  = $name;
        $this->value = $value;
        $this->meta  = $meta;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function getValue()
    {
        return $this->value;
    }
}