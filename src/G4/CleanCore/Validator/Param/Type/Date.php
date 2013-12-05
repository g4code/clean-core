<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\String;

class Date extends String
{

    public function isInValidRange()
    {
        $date = \DateTime::createFromFormat($this->_meta['valid'], $this->_value);

        return $date !== false
            && $date->format($this->_meta['valid']) == $this->_value;
    }
}