<?php

namespace G4\CleanCore\Validator\Param\Type;

interface TypeInterface
{
    public function cast();

    public function defaultValue();

    public function required();

    public function type();

    public function validValue();
}