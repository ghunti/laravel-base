<?php
namespace Ghunti\LaravelBase\Validation;

use Illuminate\Validation\Validator as BaseValidator;
use Ghunti\LaravelBase\Exception\ValidatorException;

class Validator extends BaseValidator
{
    /**
     * Check if the current validator passes validation, and throws an
     * exception if it doesn't pass
     *
     * @throws Ghunti\LaravelBase\Exception\ValidatorException Exception thrown if validation fails
     * @return boolean True if the validator passes validation]
     */
    public function passOrFail()
    {
        if (!$this->passes()) {
            throw new ValidatorException($this);
        }
        return true;
    }
}
