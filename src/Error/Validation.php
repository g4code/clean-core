<?php

namespace G4\CleanCore\Error;

//TODO: Drasko: refactor this!
class Validation
{
    
    /**
     * @var \G4\CleanCore\Exception\Validation[]
     */
    private $_exceptions;

    private $_messages;

    public function __construct()
    {
        $this->_exceptions = array();
        $this->_messages   = array();
    }
    
    public function addException(\G4\CleanCore\Exception\Validation $exception)
    {
        $this->_exceptions[] = $exception;
        return $this;
    }

    public function getMessages()
    {
        $this->_iterateTroughExceptions();

        return array(
            'invalid_params' => $this->_messages
        );
    }

    public function hasErrors()
    {
        return !empty($this->_exceptions);
    }
    
    private function _addMessage(\G4\CleanCore\Exception\Validation $exception)
    {
        $this->_messages[] = [
            $exception->getName() =>  $exception->getValue()
        ];
    }

    private function _iterateTroughExceptions()
    {
        foreach($this->_exceptions as $oneException)
        {
            $this->_addMessage($oneException);
        }
    }
}