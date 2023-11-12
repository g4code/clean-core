<?php

namespace G4\CleanCore\Validator;

use G4\CleanCore\Validator\Param\Param;
use G4\CleanCore\Request\Request;

class Validator implements ValidatorInterface
{
    final public const TYPE_ARRAY = 'ArrayType';
    final public const TYPE_JSON = 'Json';
    final public const TYPE_DATE = 'Date';
    final public const TYPE_EMAIL = 'Email';
    final public const TYPE_INT = 'IntValidator';
    final public const TYPE_INT_POSITIVE = 'IntPositive';
    final public const TYPE_INT_NEGATIVE = 'IntNegative';
    final public const TYPE_INT_ZERO_POSITIVE = 'IntZeroPositive';
    final public const TYPE_INT_ZERO_NEGATIVE = 'IntZeroNegative';
    final public const TYPE_IP = 'Ip';
    final public const TYPE_MD5 = 'Md5';
    final public const TYPE_STRING = 'StringValidator';
    final public const TYPE_STRING_VALID_JSON = 'StringValidJson';
    final public const TYPE_URL = 'Url';

    private ?array $meta = null;

    private array $params = [];

    private ?\G4\CleanCore\Request\Request $request = null;

    private bool $valid = true;

    private readonly \G4\CleanCore\Error\Validation $error;

    private array $whitelistParams = [];


    public function __construct()
    {
        $this->error = new \G4\CleanCore\Error\Validation();
    }

    public function getErrorMessages(): array
    {
        return $this->error->getMessages();
    }

    public function isValid(): bool
    {
        $this->validate();
        $this->request
            ->mergeParams($this->params)
            ->filterParams($this->getWhitelistParams());
        return $this->valid;
    }

    public function setMeta(array $meta): self
    {
        $this->meta = $meta;
        return $this;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function setWhitelistParams(array $whitelistParams): self
    {
        $this->whitelistParams = $whitelistParams;
        return $this;
    }

    private function validate(): void
    {
        $this->iterateTroughMeta();

        if ($this->error->hasErrors()) {
            $this->valid = false;
        }
    }

    private function addToParams($paramName, $meta): void
    {
        try {
            $param = new Param($paramName, $this->request, $meta);
            $this->params[$paramName] = $param->getValue();
        } catch (\G4\CleanCore\Exception\Validation $exception) {
            $this->error->addException($exception);
        }
    }

    private function getWhitelistParams(): array
    {
        return array_merge($this->whitelistParams, array_keys($this->params));
    }

    private function iterateTroughMeta(): void
    {
        foreach ($this->meta as $paramName => $meta) {
            $this->addToParams($paramName, $meta);
        }
    }
}
