<?php

namespace G4\CleanCore\Service;

interface ServiceInterface
{
    public function getFormatterInstance(): \G4\CleanCore\Formatter\FormatterInterface;

    public function getMeta(): array;

    public function getUseCaseInstance(): \G4\CleanCore\UseCase\UseCaseAbstract;
}
