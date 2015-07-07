<?php

namespace G4\CleanCore\Validator\Param;

use G4\CleanCore\Request\Request;

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
    protected $_meta; //TODO: Drasko: should be private!

    protected $_name; //TODO: Drasko: should be private!

    protected $_value; //TODO: Drasko: should be private!

    private $request;

    public function __construct($name, Request $request, $meta)
    {
        $this->_name   = $name;
        $this->request = $request;
        $this->_value  = $request->getParam($name);
        $this->_meta   = $meta;
    }

    public function getRequest()
    {
        return $this->request;
    }
}