<?php

namespace G4\CleanCore\Formatter\Collection;

class IteratorFactory
{
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function getIterator(): \Zend\Paginator\Adapter\AdapterInterface
    {
        return $this->_isIterator()
            ? new \Zend\Paginator\Adapter\Iterator($this->collection)
            : new \Zend\Paginator\Adapter\ArrayAdapter($this->collection);
    }

    private function _isIterator(): bool
    {
        return $this->collection instanceof \Iterator
            && $this->collection instanceof \Countable;
    }
}