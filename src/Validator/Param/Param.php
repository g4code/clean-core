<?php

namespace G4\CleanCore\Validator\Param;

use G4\CleanCore\Validator\Param\ParamAbstract;

class Param extends ParamAbstract
{
    public function getValue()
    {
        return $this->factory()->getValue();
    }

    private function factory()
    {
        $className = class_exists($this->_meta['type'])
            ? $this->_meta['type']
            : 'G4\CleanCore\Validator\Param\Type\\' . $this->_meta['type'];
        return new $className($this->_name, $this->getRequest(), $this->_meta);
    }
}