<?php

namespace G4\CleanCore\Service\Generic;

use G4\CleanCore\Service\ServiceAbstract;

abstract class GenericAbstract extends ServiceAbstract
{

    public function areParamsValid()
    {
        return true;
    }

    public function getResponseData()
    {
        return null;
    }

    public function hasResourse()
    {
        return false;
    }

    protected function _formatResponse()
    {
        return null;
    }

    protected function _getResponseInstance()
    {
        return $this;
    }
}