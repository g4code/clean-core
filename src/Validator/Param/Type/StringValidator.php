<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\TypeAbstract;

class StringValidator extends TypeAbstract
{
    public function cast()
    {
        if (!$this->isValueNull()) {
            $this->value = is_array($this->value) || is_object($this->value) ? $this->value : (string) $this->value;
        }
        return $this;
    }

    public function isValueNull(): bool
    {
        return $this->value === null || $this->value === '';
    }

    public function type(): bool
    {
        return is_string($this->value);
    }
}
