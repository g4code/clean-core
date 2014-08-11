<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\TypeAbstract;

class IntZeroNegative extends \G4\CleanCore\Validator\Param\Type\Int
{
    public function type()
    {
        return parent::type() && $this->_value <= 0;
    }
}