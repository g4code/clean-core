<?php

namespace G4\CleanCore\Validator\Param\Type;

class Json extends ArrayType
{
    public function cast(): self
    {
        if($this->_isNotEmptyString()) {
            $this->value = json_decode($this->value, true);
        }

        if($this->_isNotEmptyString() && json_last_error() !== JSON_ERROR_NONE) {
            throw new \G4\CleanCore\Exception\Validation($this->name, $this->value, $this->meta);
        }

        if($this->isValueEmptyString()) {
            $this->value = null;
        }

        return $this;
    }
}