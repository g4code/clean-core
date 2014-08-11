<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\String;

class Url extends String
{
    public function type()
    {
        return parent::type()
            && filter_var($this->_value, FILTER_VALIDATE_URL);
    }
}