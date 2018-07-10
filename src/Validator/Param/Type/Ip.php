<?php

namespace G4\CleanCore\Validator\Param\Type;

class Ip extends StringValidator
{
    public function type()
    {
        return parent::type()
            && filter_var($this->_value, FILTER_VALIDATE_IP);
    }
}