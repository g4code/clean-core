<?php

namespace G4\CleanCore\Validator\Param\Type;

class IntNegative extends \G4\CleanCore\Validator\Param\Type\Int
{
    public function type()
    {
        return parent::type() && $this->_value < 0;
    }
}