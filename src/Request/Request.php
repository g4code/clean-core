<?php

namespace G4\CleanCore\Request;

class Request
{

    private ?bool $ajaxCall = null;

    private ?array $anonymizationRules = null;

    /**
     * Valid methods
     * index, get, post, put, delete
     */
    private ?string $method = null;

    private ?string $module = null;

    private array $params = [];

    private ?string $rawInput = null;

    /**
     * Resource name
     */
    private ?string $resourceName = null;

    private ?array $serverVariables = null;

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

    public function getParam(string $key): mixed
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
            throw new \Exception("Rule for '$param' already exists.");
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

    public function mergeParams(array|string $params): self
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

    public function setParam(string $key, mixed $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function setParams(array|string $params): self
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

    public function getInt(string $key): ?int
    {
        return filter_var($this->getParam($key), FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }

    public function getString(string $key): ?string
    {
        $param = $this->getParam($key);
        return $param ? (string) $param: null;
    }

    public function getBoolean(string $key): ?bool
    {
        return filter_var($this->getParam($key), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    public function getArray(string $key): ?array
    {
        $param = $this->getParam($key);
        return $param ? (array) $param : null;
    }
}
