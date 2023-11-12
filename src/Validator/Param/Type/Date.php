<?php

namespace G4\CleanCore\Validator\Param\Type;

class Date extends StringValidator
{
    public function isInValidRange(): bool
    {
        $date = \DateTime::createFromFormat($this->meta['valid'], $this->value ?: '');

        return $date !== false
            && $date->format($this->meta['valid']) === $this->value;
    }
}
