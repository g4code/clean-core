<?php

namespace G4\CleanCore\Meta;

class Meta
{

    private $data;

    public function __construct()
    {
        $this->data = [];
    }

    public function add($valueObject)
    {
        $this->data[] = $valueObject;
    }


}