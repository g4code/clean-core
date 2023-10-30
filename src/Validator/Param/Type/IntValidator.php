<?php

namespace G4\CleanCore\Validator\Param\Type;

class IntValidator extends TypeAbstract
{
    public function cast()
    {
        if ($this->isValueEmptyString()) {
            $this->value = null;
        }

        if (!$this->isValueNull()) {
            $this->value = (int) $this->value;
        }
        return $this;
    }

    public function isValueNull(): bool
    {
        return $this->value === null;
    }

    public function type(): bool
    {
        return is_int($this->value);
    }
}
