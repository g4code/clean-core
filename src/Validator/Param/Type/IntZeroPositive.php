<?php

namespace G4\CleanCore\Validator\Param\Type;

class IntZeroPositive extends IntValidator
{
    public function type(): bool
    {
        return parent::type() && $this->value >= 0;
    }
}