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
    protected $meta; //TODO: Drasko: should be private!

    protected $name; //TODO: Drasko: should be private!

    protected $value; //TODO: Drasko: should be private!

    private $request;

    public function __construct($name, Request $request, $meta)
    {
        $this->name   = $name;
        $this->request = $request;
        $this->value  = $request->getParam($name);
        $this->meta   = $meta;
    }

    public function getRequest()
    {
        return $this->request;
    }
}
