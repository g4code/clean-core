<?php

namespace G4\CleanCore\Validator\Param\Type;

class IntNegative extends IntValidator
{
    public function type(): bool
    {
        return parent::type() && $this->value < 0;
    }
}