<?php

namespace G4\CleanCore\Validator\Param\Type;

class ArrayType extends TypeAbstract
{
    public function cast(): static
    {
        if ($this->isNotEmptyString()) {
            $this->value = explode($this->getArrayValueSeparator(), (string) $this->value);
        }

        if ($this->isValueEmptyString()) {
            $this->value = null;
        }

        return $this;
    }

    public function type(): bool
    {
        return is_array($this->value);
    }

    public function validValue(): self
    {
        if ($this->isValidMetaSet() && is_array($this->value)) {
            $this->value = array_intersect($this->getValidValues(), $this->value);
        }
        return $this;
    }

    protected function isNotEmptyString(): bool
    {
        return !$this->isValueNull()
            && is_string($this->value)
            && !$this->isValueEmptyString();
    }
}
