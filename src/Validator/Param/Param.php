<?php

namespace G4\CleanCore\Validator\Param;

use G4\CleanCore\Validator\Param\ParamAbstract;

class Param extends ParamAbstract
{
    public function getValue()
    {
        return $this->factory()->getValue();
    }

    private function factory(): object
    {
        $className = class_exists($this->meta['type'])
            ? $this->meta['type']
            : 'G4\CleanCore\Validator\Param\Type\\' . $this->meta['type'];
        return new $className($this->name, $this->getRequest(), $this->meta);
    }
}