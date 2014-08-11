<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\String;

class Md5 extends String
{
    public function type()
    {
        return parent::type()
            && preg_match('/^[a-f0-9]{32}$/', $this->_value);
    }
}