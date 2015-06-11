<?php

namespace G4\CleanCore\Request;

class Request
{

    /**
     * @var bool
     */
    private $ajaxCall;

    /**
     * Valid methods
     * index, get, post, put, delete
     * @var string
     */
    private $_method;

    /**
     * @var string
     */
    private $_module;

    /**
     * @var array
     */
    private $_params;

    /**
     * Resource name
     * @var string
     */
    private $_resourceName;

    /**
     * @var array
     */
    private $anonymizationRules;

    public function __construct()
    {
        $this->_params = array();
    }

    /**
     * @param array $whitelistParamKeys
     * @return \G4\CleanCore\Request\Request
     */
    public function filterParams(array $whitelistParamKeys)
    {
        $this->_params = array_intersect_key($this->_params, array_flip($whitelistParamKeys));
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->_module;
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

    public function setAnonymizationRules($param, $rule)
    {
        if(isset($this->anonymizationRules[$param])) {
            throw new \Exception("Rule for '{$param}' already exists.");
        }

        $this->anonymizationRules[$param] = $rule;
        return $this;
    }

    public function getParamsAnonymized()
    {
        $cleanParams = $this->getParams();

        if(is_array($this->anonymizationRules)) {
            foreach ($this->anonymizationRules as $key => $rule) {
                if(isset($cleanParams[$key])) {
                    if($rule === null) {
                        unset($cleanParams[$key]);
                    } else {
                        $cleanParams[$key] = is_callable($rule)
                            ? $rule($cleanParams[$key])
                            : $rule;
                    }
                }
            }
        }

        return $cleanParams;
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

    public function isAjax()
    {
        return (bool) $this->ajaxCall;
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

    public function setAjaxCall($ajaxCall)
    {
        $this->ajaxCall = $ajaxCall;
        return $this;
    }

    /**
     * @param string $method
     * @return \G4\CleanCore\Request\Request
     */
    public function setMethod($method)
    {
        $this->_method = $method;
        return $this;
    }

    /**
     * @param string $module
     * @return \G4\CleanCore\Request\Request
     */
    public function setModule($module)
    {
        $this->_module = $module;
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
     * @param string $resource
     * @return \G4\CleanCore\Request\Request
     */
    public function setResourceName($resourceName)
    {
        $this->_resourceName = $resourceName;
        return $this;
    }

    /**
     * @param string $key
     * @return \G4\CleanCore\Request\Request
     */
    public function unsetParam($key)
    {
        unset($this->_params[$key]);
        return $this;
    }
}