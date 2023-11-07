<?php

namespace G4\CleanCore\Validator\Param;

use G4\CleanCore\Request\Request;

abstract class ParamAbstract implements ParamInterface
{
    //TODO: Drasko: should be private!
    protected $value;

    /**
     *  Possible options:
     *      default
     *      required
     *      separator
     *      type
     *      valid
     * @param mixed[] $meta
     */
    public function __construct(protected $name, private readonly Request $request, protected $meta)
    {
        $this->value  = $request->getParam($name);
    }

    public function getRequest()
    {
        return $this->request;
    }
}
