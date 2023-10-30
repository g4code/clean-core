<?php

namespace G4\CleanCore\Error;

//TODO: Drasko: refactor this!
class Validation
{
    
    /**
     * @var \G4\CleanCore\Exception\Validation[]
     */
    private $exceptions = [];

    private $messages = [];

    public function __construct()
    {
    }
    
    public function addException(\G4\CleanCore\Exception\Validation $exception): self
    {
        $this->exceptions[] = $exception;
        return $this;
    }

    public function getMessages(): array
    {
        $this->iterateTroughExceptions();

        return ['invalid_params' => $this->messages];
    }

    public function hasErrors(): bool
    {
        return !empty($this->exceptions);
    }
    
    private function addMessage(\G4\CleanCore\Exception\Validation $exception): void
    {
        $this->messages[] = [
            $exception->getName() =>  $exception->getValue()
        ];
    }

    private function iterateTroughExceptions(): void
    {
        foreach ($this->exceptions as $oneException) {
            $this->addMessage($oneException);
        }
    }
}
