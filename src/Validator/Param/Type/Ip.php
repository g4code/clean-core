<?php

namespace G4\CleanCore\Validator\Param\Type;

class Ip extends StringValidator
{
    public function type(): bool
    {
        return parent::type()
            && filter_var($this->value, FILTER_VALIDATE_IP);
    }
}