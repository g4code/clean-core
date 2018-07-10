<?php

namespace G4\CleanCore\Validator\Param\Type;

class Md5 extends StringValidator
{
    public function type()
    {
        return parent::type()
            && preg_match('/^[a-f0-9]{32}$/', $this->_value);
    }
}