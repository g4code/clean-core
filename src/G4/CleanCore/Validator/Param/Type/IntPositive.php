<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\TypeAbstract;

class IntPositive extends \G4\CleanCore\Validator\Param\Type\Int
{

    public function type()
    {
        return parent::type() && $this->_value < 0;
    }
}