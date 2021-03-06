<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\ParamAbstract;
use G4\CleanCore\Validator\Param\Type\TypeInterface;

abstract class TypeAbstract extends ParamAbstract implements TypeInterface
{
    const ARRAY_VALUE_SEPARATOR = '|';
    const IS_VALID_META_STRICT = false; // @ToDo: This is a feature flag for invalid optional parameter value; Clean up when flag is removed (Sasa|08/2018)

    /**
     * @return TypeAbstract
     */
    public function defaultValue()
    {
        if ($this->hasDefault() && $this->isValueNull()) {
            $this->_value = $this->getDefaultValues();
        }
        return $this;
    }

    public function getArrayValueSeparator()
    {
        return !empty($this->_meta['separator']) && is_string($this->_meta['separator'])
            ? $this->_meta['separator']
            : self::ARRAY_VALUE_SEPARATOR;
    }

    public function getDefaultValues()
    {
        return is_callable($this->_meta['default'])
            ? call_user_func($this->_meta['default'])
            : $this->_meta['default'];
    }

    public function getValidValues()
    {
        return is_callable($this->_meta['valid'])
            ? call_user_func($this->_meta['valid'])
            : (is_array($this->_meta['valid']) ? $this->_meta['valid'] : array());
    }

    public function getValue()
    {
        $this->cast()
             ->validValue()
             ->validType()
             ->required()
             ->defaultValue();

        return $this->_value;
    }

    public function isRequiredMetaSet()
    {
        return isset($this->_meta['required'])
            && $this->_meta['required'] === true;
    }

    public function isRequiredNotSet()
    {
        return $this->isRequiredMetaSet()
            && ($this->isValueNull() || !$this->type());
    }

    public function isInValidRange()
    {
        return in_array($this->_value, $this->getValidValues());
    }

    public function isValidMetaSet()
    {
        return isset($this->_meta['valid']);
    }

    public function isValidMetaStrict()
    {
        return self::IS_VALID_META_STRICT; // @ToDo: This is a feature flag for invalid optional parameter value (Sasa|08/2018)
    }

    public function isValueEmptyString()
    {
        return $this->_value === '';
    }

    public function isValueNull()
    {
        return $this->_value === null
            || (empty($this->_value)
            && (is_array($this->_value) || is_string($this->_value)));
    }

    public function hasDefault()
    {
        return isset($this->_meta['default']);
    }

    /**
     * @return TypeAbstract
     */
    public function required()
    {
        if ($this->isRequiredNotSet()) {
            throw new \G4\CleanCore\Exception\Validation($this->_name, $this->_value, $this->_meta);
        }
        return $this;
    }

    /**
     * @return TypeAbstract
     */
    public function validType()
    {
        if (!$this->isValueNull() && !$this->type()) {
            throw new \G4\CleanCore\Exception\Validation($this->_name, $this->_value, $this->_meta);
        }
        return $this;
    }

    /**
     * @return TypeAbstract
     */
    public function validValue()
    {
        if ($this->isValidMetaStrict()) { // @ToDo: This is a feature flag for invalid optional parameter value; Clean up when flag is removed (Sasa|08/2018)
            if (
                $this->isValidMetaSet() && !$this->isInValidRange() && // value is invalid
                !($this->isValueNull() && !$this->isRequiredMetaSet()) // null value is invalid only if parameter is required
            ) {
                throw new \G4\CleanCore\Exception\Validation($this->_name, $this->_value, $this->_meta);
            }
        } else { // @ToDo: This is an old incorrect state; Remove with feature flag for invalid optional parameter value (Sasa|08/2018)
            if ($this->isValidMetaSet() && !$this->isInValidRange()) {
                $this->_value = null;
            }
        }
        return $this;
    }
}