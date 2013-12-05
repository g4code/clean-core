<?php

namespace G4\CleanCore\Service\Generic;

use G4\CleanCore\Service\Generic\GenericAbstract;

class BadRequest extends GenericAbstract
{


    public function __construct()
    {
        $this->setCode(400);
    }

}