<?php

namespace Ghunti\LaravelBase\Exception;

use Illuminate\Contracts\Validation\Validator;

class ValidatorException extends \Exception
{
    /**
     * A validator object
     * @var Illuminate\Validation\Validator
     */
    protected $validator;

    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        //Our message is actually a Validator
        if ($message instanceof Validator) {
            $this->validator = $message;
            $message = $this->validator->messages()->first();
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns the validator object
     *
     * @return Illuminate\Validation\Validator The validator object
     */
    public function getValidator()
    {
        return $this->validator;
    }
}
