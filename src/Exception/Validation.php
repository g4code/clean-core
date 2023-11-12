<?php

namespace G4\CleanCore\Exception;

class Validation extends \Exception
{
    public function __construct(protected $name, protected $value, protected $meta)
    {
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
