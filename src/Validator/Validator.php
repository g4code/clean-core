<?php

namespace G4\CleanCore\Validator;

use G4\CleanCore\Validator\Param\Param;
use G4\CleanCore\Request\Request;

class Validator implements ValidatorInterface
{
    public const TYPE_ARRAY = 'ArrayType';
    public const TYPE_JSON = 'Json';
    public const TYPE_DATE = 'Date';
    public const TYPE_EMAIL = 'Email';
    public const TYPE_INT = 'IntValidator';
    public const TYPE_INT_POSITIVE = 'IntPositive';
    public const TYPE_INT_NEGATIVE = 'IntNegative';
    public const TYPE_INT_ZERO_POSITIVE = 'IntZeroPositive';
    public const TYPE_INT_ZERO_NEGATIVE = 'IntZeroNegative';
    public const TYPE_IP = 'Ip';
    public const TYPE_MD5 = 'Md5';
    public const TYPE_STRING = 'StringValidator';
    public const TYPE_STRING_VALID_JSON = 'StringValidJson';
    public const TYPE_URL = 'Url';

    /**
     * @var array
     */
    private $meta;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var Request
     */
    private $request;

    /**
     * @var bool
     */
    private $valid = true;

    /**
     * @var \G4\CleanCore\Error\Validation
     */
    private $error;

    /**
     * @var array
     */
    private $whitelistParams = [];


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