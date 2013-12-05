<?php

namespace G4\CleanCore\Service\Generic;

use G4\CleanCore\Service\Generic\GenericAbstract;

class NotFound extends GenericAbstract
{

     public function __construct()
    {
        $this->setCode(404);
    }
}