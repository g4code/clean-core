<?php

namespace G4\CleanCore\Validator\Param\Type;

class Email extends StringValidator
{
    public function type(): bool
    {
        $this->value = preg_replace('/\s+/', '+', trim($this->value));
        return parent::type()
            && filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }
}