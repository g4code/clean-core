<?php

namespace G4\CleanCore\Validator;

use G4\CleanCore\Validator\ValidatorInterface;
use G4\CleanCore\Validator\Param\Param;
use G4\CleanCore\Request\Request;

class Validator implements ValidatorInterface
{
    const TYPE_ARRAY             = 'ArrayType';
    const TYPE_JSON              = 'Json';
    const TYPE_DATE              = 'Date';
    const TYPE_EMAIL             = 'Email';
    const TYPE_INT               = 'Int';
    const TYPE_INT_POSITIVE      = 'IntPositive';
    const TYPE_INT_NEGATIVE      = 'IntNegative';
    const TYPE_INT_ZERO_POSITIVE = 'IntZeroPositive';
    const TYPE_INT_ZERO_NEGATIVE = 'IntZeroNegative';
    const TYPE_IP                = 'Ip';
    const TYPE_MD5               = 'Md5';
    const TYPE_STRING            = 'String';
    const TYPE_STRING_VALID_JSON = 'StringValidJson';
    const TYPE_URL               = 'Url';

    /**
     * @var array
     */
    private $meta;

    /**
     * @var array
     */
    private $params;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var bool
     */
    private $valid;

    /**
     * @var \G4\CleanCore\Error\Validation
     */
    private $error;

    /**
     * @var array
     */
    private $whitelistParams;


    public function __construct()
    {
        $this->error           = new \G4\CleanCore\Error\Validation();
        $this->params          = [];
        $this->valid           = true;
        $this->whitelistParams = [];
    }

    public function getErrorMessages()
    {
        return $this->error->getMessages();
    }

    public function isValid()
    {
        $this->validate();
        $this->request
            ->mergeParams($this->params)
            ->filterParams($this->getWhitelistParams());
        return $this->valid;
    }

    /**
     * @param array $meta
     * @return \G4\CleanCore\Validator\Validator
     */
    public function setMeta(array $meta)
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @param \G4\CleanCore\Request\Request $request
     * @return \G4\CleanCore\Validator\Validator
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @param array $whitelistParams
     * @return \G4\CleanCore\Validator\Validator
     */
    public function setWhitelistParams(array $whitelistParams)
    {
        $this->whitelistParams = $whitelistParams;
        return $this;
    }

    private function validate()
    {
        $this->iterateTroughMeta();

        if ($this->error->hasErrors()) {
            $this->valid = false;
        }
    }

    private function addToParams($paramName, $meta)
    {
        try {

            $param = new Param($paramName, $this->request, $meta);
            $this->params[$paramName] = $param->getValue();

        } catch (\G4\CleanCore\Exception\Validation $exception) {

            $this->error->addException($exception);
        }
    }

    private function getWhitelistParams()
    {
        return array_merge($this->whitelistParams, array_keys($this->params));
    }

    private function iterateTroughMeta()
    {
        foreach ($this->meta as $paramName => $meta) {
            $this->addToParams($paramName, $meta);
        }
    }
}