<?php

namespace G4\CleanCore\Service\Generic;

use G4\CleanCore\Service\Generic\GenericAbstract;

class Api_Model_Service_Generic_Conflict extends GenericAbstract
{

    public function __construct()
    {
        $this->setCode(409);
    }

}