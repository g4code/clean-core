<?php

namespace G4\CleanCore\Validator\Param\Type;

class StringValidJson extends StringValidator
{
    public function cast(): self
    {
        parent::cast();

        if (!$this->isValueNull()) {
            $valid = json_decode($this->value, true);
            if(json_last_error() !== JSON_ERROR_NONE) {
                throw new \G4\CleanCore\Exception\Validation($this->name, $this->value, $this->meta);
            }
        }

        return $this;
    }

}