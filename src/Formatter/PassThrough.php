<?php

namespace G4\CleanCore\Formatter;

use G4\CleanCore\Formatter\FormatterAbstract;

final class PassThrough extends FormatterAbstract
{

    public function format()
    {
        return $this->getResource();
    }
}