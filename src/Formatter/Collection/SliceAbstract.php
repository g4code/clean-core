<?php

namespace G4\CleanCore\Formatter\Collection;

abstract class SliceAbstract extends CollectionAbstract
{
    public function format(): array
    {
        if ($this->hasItems()) {
            foreach ($this->getResourceCollection() as $resource) {
                $this->formatOneResource($resource);
            }
        }
        return $this->getPaginatorResponse();
    }

    public function isCollectionCountable(): bool
    {
        return is_countable($this->getResourceCollection());
    }

    public function isCollectionIterator(): bool
    {
        return $this->getResourceCollection() instanceof \Iterator;
    }

    //TODO: Drasko: this needs refactoring!
    protected function getPaginatorResponse(): array
    {
        $totalItems = $this->getTotalItemsCount();
        $resource   = $this->getResource();
        $data       = $this->getData();

        return ['current_page_number' => !empty($resource) ? $this->getResource('page') : null, 'total_item_count'    => $totalItems, 'item_count_per_page' => !empty($resource) ? $this->getResource('per_page') : null, 'current_item_count'  => is_countable($data) ? count($data) : 0, 'page_count'          => !empty($resource) ? ceil($totalItems / $this->getResource('per_page')) : 0, 'current_items'       => $data];
    }

    private function collectionNotCountable()
    {
        throw new \Exception('Collection does not implement Countable', 500);
    }

    private function getCollectionCount()
    {
        $collection = $this->getResourceCollection();

        return $this->isCollectionCountable()
            ? count($collection)
            : $this->collectionNotCountable();
    }

    private function hasItems(): bool
    {
        return $this->getCollectionCount() > 0;
    }

    private function getTotalItemsCount()
    {
        return is_object($this->getResourceCollection()) && method_exists($this->getResourceCollection(), 'getTotalItemsCount')
            ? $this->getResourceCollection()->getTotalItemsCount()
            : $this->getCollectionCount();
    }
}