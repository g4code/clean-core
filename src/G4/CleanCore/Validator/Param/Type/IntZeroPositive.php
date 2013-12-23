<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\TypeAbstract;

class IntZeroPositive extends Int
{
    public function type()
    {
        return parent::type() && $this->_value >= 0;
    }
}