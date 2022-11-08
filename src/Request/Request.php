<?php

namespace G4\CleanCore\Request;

class Request
{

    /**
     * @var bool
     */
    private $ajaxCall;

    /**
     * @var array
     */
    private $anonymizationRules;

    /**
     * Valid methods
     * index, get, post, put, delete
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $module;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private $rawInput;

    /**
     * Resource name
     * @var string
     */
    private $resourceName;

    /**
     * @var array
     */
    private $serverVariables;

    public function __construct()
    {
    }

    public function filterParams(array $whitelistParamKeys): self
    {
        $this->params = array_intersect_key($this->params, array_flip($whitelistParamKeys));
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @return null|int|string|array
     */
    public function getParam(string $key)
    {
        return $this->hasParam($key)
            ? $this->params[$key]
            : null;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getRawInput(): string
    {
        return $this->rawInput;
    }

    public function getServerVariable(string $key): ?string
    {
        return is_array($this->serverVariables) && isset($this->serverVariables[$key])
            ? $this->serverVariables[$key]
            : null;
    }

    public function setAnonymizationRules($param, $rule): self
    {
        if (isset($this->anonymizationRules[$param])) {
            throw new \Exception("Rule for '{$param}' already exists.");
        }

        $this->anonymizationRules[$param] = $rule;
        return $this;
    }

    public function getParamsAnonymized(): array
    {
        $cleanParams = $this->getParams();

        if (is_array($this->anonymizationRules)) {
            foreach ($this->anonymizationRules as $key => $rule) {
                if (isset($cleanParams[$key])) {
                    if ($rule === null) {
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

    public function getResourceName(): string
    {
        return $this->resourceName;
    }

    public function hasParam(string $key): bool
    {
        return isset($this->params[$key]);
    }

    public function isAjax(): bool
    {
        return (bool) $this->ajaxCall;
    }

    /**
     * @param array|string $params
     */
    public function mergeParams($params): self
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function setAjaxCall(bool $ajaxCall): self
    {
        $this->ajaxCall = $ajaxCall;
        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function setModule(string $module): self
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @param mixed $value
     */
    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * @param array|string $params
     */
    public function setParams($params): self
    {
        is_array($params)
            ? ($this->params = $params)
            : parse_str($params, $this->params);

        return $this;
    }

    public function setRawInput(string $value): self
    {
        $this->rawInput = $value;
        return $this;
    }

    public function setResourceName(string $resourceName): self
    {
        $this->resourceName = $resourceName;
        return $this;
    }

    public function setServerVariables(array $value): self
    {
        $this->serverVariables = $value;
        return $this;
    }

    public function unsetParam(string $key): self
    {
        unset($this->params[$key]);
        return $this;
    }

    /**
     * @return int
     */
    public function getInt(string $key)
    {
        return filter_var($this->getParam($key), FILTER_VALIDATE_INT);
    }

    public function getBoolean(string $key): bool
    {
        return filter_var($this->getParam($key), FILTER_VALIDATE_BOOLEAN);
    }
}
