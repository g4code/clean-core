<?php

namespace G4\CleanCore\Formatter\Collection;

abstract class PaginationAbstract extends CollectionAbstract
{

    private $paginator;


    public function format(): array
    {
        $this->setPaginator();

        if ($this->hasItems()) {
            foreach ($this->paginator as $resource) {
                $this->formatOneResource($resource);
            }
        }

        return $this->getPaginatorResponse();
    }

    protected function getPaginatorResponse(): array
    {
        return [
            'current_page_number' => $this->paginator->getCurrentPageNumber(),
            'total_item_count' => $this->paginator->getTotalItemCount(),
            'item_count_per_page' => $this->paginator->getItemCountPerPage(),
            'current_item_count' => $this->paginator->getCurrentItemCount(),
            'page_count' => is_countable($this->paginator) ? count($this->paginator) : 0,
            'current_items' => $this->getData()
        ];
    }

    protected function getResourcePage()
    {
        $page = $this->getResource('page');
        return empty($page)
            ? 1
            : $page;
    }

    protected function getResourcePerPage()
    {
        $perPage = $this->getResource('per_page');
        return empty($perPage)
            ? 1
            : $perPage;
    }

    protected function setPaginator(): self
    {
        $iteratorFactory = new \G4\CleanCore\Formatter\Collection\IteratorFactory($this->getResourceCollection());
        $this->paginator = new \Laminas\Paginator\Paginator($iteratorFactory->getIterator());
        $this->paginator
            ->setItemCountPerPage($this->getResourcePerPage())
            ->setCurrentPageNumber($this->getResourcePage());

        return $this;
    }

    private function hasItems(): bool
    {
        return is_object($this->paginator)
            && $this->paginator->getItemCount($this->paginator) > 0
            && $this->getResource('page') <= (is_countable($this->paginator) ? count($this->paginator) : 0);
    }
}
