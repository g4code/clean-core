<?php

namespace G4\CleanCore\Formatter;

interface FormatterInterface
{
    public function format();

    public function setResource($resource);
}