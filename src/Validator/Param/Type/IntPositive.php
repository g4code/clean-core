<?php

namespace G4\CleanCore\Validator\Param\Type;

class IntPositive extends IntValidator
{
    public function type()
    {
        return parent::type() && $this->_value > 0;
    }
}