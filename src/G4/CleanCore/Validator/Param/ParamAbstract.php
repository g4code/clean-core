<?php

namespace G4\CleanCore\Validator\Param;

abstract class ParamAbstract implements ParamInterface
{
    /**
     * Possible options:
     *     default
     *     required
     *     separator
     *     type
     *     valid
     *
     * @var array
     */
    protected $_meta;

    protected $_name;

    protected $_value;

    public function __construct($name, $value, $meta)
    {
        $this->_name  = $name;
        $this->_value = $value;
        $this->_meta  = $meta;
    }
}