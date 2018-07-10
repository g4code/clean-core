<?php

namespace G4\CleanCore\Validator\Param\Type;

class StringValidJson extends StringValidator
{
    public function cast()
    {
        parent::cast();

        if (!$this->isValueNull()) {
            $valid = json_decode($this->_value, true);
            if(json_last_error() !== JSON_ERROR_NONE) {
                throw new \G4\CleanCore\Exception\Validation($this->_name, $this->_value, $this->_meta);
            }
        }

        return $this;
    }

}