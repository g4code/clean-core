<?php

namespace G4\CleanCore\Validator;

use G4\CleanCore\Request\Request;

interface ValidatorInterface
{
    public function isValid();

    public function setMeta(array $meta);

    public function setRequest(Request $request);
}