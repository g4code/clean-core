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
    protected $_meta;

    /**
     * @var array
     */
    protected $_params;

    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var bool
     */
    protected $_valid;

    /**
     * @var \G4\CleanCore\Error\Validation
     */
    private $_error;

    /**
     * @var array
     */
    private $_whitelistParams;


    public function __construct()
    {
        $this->_error           = new \G4\CleanCore\Error\Validation();
        $this->_params          = array();
        $this->_valid           = true;
        $this->_whitelistParams = array();
    }

    public function getErrorMessages()
    {
        return $this->_error->getMessages();
    }

    public function isValid()
    {
        $this->_validate();
        $this->_request
            ->mergeParams($this->_params)
            ->filterParams($this->_getWhitelistParams());
        return $this->_valid;
    }

    /**
     * @param array $meta
     * @return \G4\CleanCore\Validator\Validator
     */
    public function setMeta(array $meta)
    {
        $this->_meta = $meta;
        return $this;
    }

    /**
     * @param \G4\CleanCore\Request\Request $request
     * @return \G4\CleanCore\Validator\Validator
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @param array $whitelistParams
     * @return \G4\CleanCore\Validator\Validator
     */
    public function setWhitelistParams(array $whitelistParams)
    {
        $this->_whitelistParams = $whitelistParams;
        return $this;
    }

    protected function _validate()
    {
        $this->_iterateTroughMeta();

        if ($this->_error->hasErrors()) {
            $this->_valid = false;
        }
    }

    private function _addToParams($paramName, $meta)
    {
        try {

            $param = new Param($paramName, $this->_request->getParam($paramName), $meta);
            $this->_params[$paramName] = $param->getValue();

        } catch (\G4\CleanCore\Exception\Validation $exception) {

            $this->_error->addException($exception);
        }
    }

    private function _getWhitelistParams()
    {
        return array_merge($this->_whitelistParams, array_keys($this->_params));
    }

    private function _iterateTroughMeta()
    {
        foreach ($this->_meta as $paramName => $meta) {
            $this->_addToParams($paramName, $meta);
        }
    }
}