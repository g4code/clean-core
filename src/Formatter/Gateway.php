<?php

namespace G4\CleanCore\Formatter;

use G4\CleanCore\Formatter\FormatterAbstract;
use G4\Constants\Parameters;

final class Gateway extends FormatterAbstract
{

    public function format()
    {
        $data = $this->getResource(Parameters::DATA);
        return empty($data)
            ? []
            : $data;
    }
}
