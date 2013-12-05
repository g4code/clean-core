<?php

namespace G4\CleanCore\Request;

class Request
{
    /**
     * Valid methods
     * index, get, post, put, delete
     * @var string
     */
    private $_method;

    /**
     * @var array
     */
    private $_params;

    /**
     * Resource name
     * @var string
     */
    private $_resourceName;


    public function __construct()
    {
        $this->_params = array();
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * @param string $key
     * @return multitype: null|string|array
     */
    public function getParam($key)
    {
        return $this->hasParam($key)
            ? $this->_params[$key]
            : null;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->_resourceName;
    }

    /**
     * @param string $key
     */
    public function hasParam($key)
    {
        return isset($this->_params[$key]);
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->_method = $method;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return \G4\CleanCore\Request\Request
     */
    public function setParam($key, $value)
    {
        $this->_params[$key] = $value;
        return $this;
    }

    /**
     * @param array|string $params
     * @return \G4\CleanCore\Request\Request
     */
    public function setParams($params)
    {
        is_array($params)
            ? ($this->_params = $params)
            : parse_str($params, $this->_params);

        return $this;
    }

    /**
     * @param array|string $params
     * @return \G4\CleanCore\Request\Request
     */
    public function mergeParams($params)
    {
        $this->_params = array_merge($this->_params, $params);
        return $this;
    }

    /**
     * @param string $resource
     * @return \G4\CleanCore\Request\Request
     */
    public function setResourceName($resourceName)
    {
        $this->_resourceName = $resourceName;

        return $this;
    }
}