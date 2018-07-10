<?php

namespace G4\CleanCore\Validator\Param\Type;

class Date extends StringValidator
{
    public function isInValidRange()
    {
        $date = \DateTime::createFromFormat($this->_meta['valid'], $this->_value);

        return $date !== false
            && $date->format($this->_meta['valid']) == $this->_value;
    }
}