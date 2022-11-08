<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\ParamAbstract;

abstract class TypeAbstract extends ParamAbstract implements TypeInterface
{
    public const ARRAY_VALUE_SEPARATOR = '|';
    // @ToDo: This is a feature flag for invalid optional parameter value; Clean up when flag is removed (Sasa|08/2018)
    public const IS_VALID_META_STRICT = false;

    /**
     * @return TypeAbstract
     */
    public function defaultValue()
    {
        if ($this->hasDefault() && $this->isValueNull()) {
            $this->value = $this->getDefaultValues();
        }
        return $this;
    }

    public function getArrayValueSeparator()
    {
        return !empty($this->meta['separator']) && is_string($this->meta['separator'])
            ? $this->meta['separator']
            : self::ARRAY_VALUE_SEPARATOR;
    }

    public function getDefaultValues()
    {
        return is_callable($this->meta['default'])
            ? call_user_func($this->meta['default'])
            : $this->meta['default'];
    }

    public function getValidValues()
    {
        return is_callable($this->meta['valid'])
            ? call_user_func($this->meta['valid'])
            : (is_array($this->meta['valid']) ? $this->meta['valid'] : []);
    }

    public function getValue()
    {
        $this->cast()
             ->validValue()
             ->validType()
             ->required()
             ->defaultValue();

        return $this->value;
    }

    public function isRequiredMetaSet(): bool
    {
        return isset($this->meta['required'])
            && $this->meta['required'] === true;
    }

    public function isRequiredNotSet(): bool
    {
        return $this->isRequiredMetaSet()
            && ($this->isValueNull() || !$this->type());
    }

    public function isInValidRange(): bool
    {
        return in_array($this->value, $this->getValidValues());
    }

    public function isValidMetaSet()
    {
        return isset($this->meta['valid']);
    }

    public function isValidMetaStrict()
    {
        // @ToDo: This is a feature flag for invalid optional parameter value (Sasa|08/2018)
        return self::IS_VALID_META_STRICT;
    }

    public function isValueEmptyString(): bool
    {
        return $this->value === '';
    }

    public function isValueNull(): bool
    {
        return $this->value === null
            || (empty($this->value)
            && (is_array($this->value) || is_string($this->value)));
    }

    public function hasDefault()
    {
        return isset($this->meta['default']);
    }

    /**
     * @return TypeAbstract
     */
    public function required()
    {
        if ($this->isRequiredNotSet()) {
            throw new \G4\CleanCore\Exception\Validation($this->name, $this->value, $this->meta);
        }
        return $this;
    }

    /**
     * @return TypeAbstract
     */
    public function validType()
    {
        if (!$this->isValueNull() && !$this->type()) {
            throw new \G4\CleanCore\Exception\Validation($this->name, $this->value, $this->meta);
        }
        return $this;
    }

    /**
     * @return TypeAbstract
     */
    public function validValue()
    {
        if ($this->isValidMetaStrict()) {
            // @ToDo: This is a feature flag for invalid optional parameter value;
            // @ToDo: Clean up when flag is removed (Sasa|08/2018)
            if ($this->isValidMetaSet() && !$this->isInValidRange() && // value is invalid
                !($this->isValueNull() && !$this->isRequiredMetaSet())
                // null value is invalid only if parameter is required
            ) {
                throw new \G4\CleanCore\Exception\Validation($this->name, $this->value, $this->meta);
            }
        } else {
            // @ToDo: This is an old incorrect state;
            // @ToDo: Remove with feature flag for invalid optional parameter value (Sasa|08/2018)
            if ($this->isValidMetaSet() && !$this->isInValidRange()) {
                $this->value = null;
            }
        }
        return $this;
    }
}
