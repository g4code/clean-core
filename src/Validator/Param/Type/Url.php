<?php

namespace G4\CleanCore\Validator\Param\Type;

class Url extends StringValidator
{
    public function type(): bool
    {
        return parent::type()
            && filter_var($this->value, FILTER_VALIDATE_URL);
    }
}
