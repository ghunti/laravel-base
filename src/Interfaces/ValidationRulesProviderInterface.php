<?php

namespace Ghunti\LaravelBase\Interfaces;

interface ValidationRulesProviderInterface
{

    /**
     * Return the validation rules
     *
     * @return array The validation rules
     */
    public function getValidationRules();
}
