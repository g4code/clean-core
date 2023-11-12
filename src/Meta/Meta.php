<?php

namespace G4\CleanCore\Meta;

class Meta
{

    private array $data = [];

    public function __construct()
    {
    }

    public function add($valueObject): void
    {
        $this->data[] = $valueObject;
    }
}
