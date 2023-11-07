<?php

namespace G4\CleanCore\Formatter\Collection;

class IteratorFactory
{
    public function __construct(private $collection)
    {
    }

    public function getIterator(): \Laminas\Paginator\Adapter\AdapterInterface
    {
        return $this->isIterator()
            ? new \Laminas\Paginator\Adapter\Iterator($this->collection)
            : new \Laminas\Paginator\Adapter\ArrayAdapter($this->collection);
    }

    private function isIterator(): bool
    {
        return $this->collection instanceof \Iterator
            && $this->collection instanceof \Countable;
    }
}
