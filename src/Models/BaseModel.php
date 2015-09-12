<?php

namespace Ghunti\LaravelBase\Models;

use Ghunti\LaravelBase\Interfaces\ValidationRulesProviderInterface;
use Ghunti\LaravelBase\Interfaces\ModelInterface;
use Ghunti\LaravelBase\Eloquent\BaseBuilder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model implements ValidationRulesProviderInterface, ModelInterface
{

    /**
     * Return validation rules for the current model.
     * If model exists, then edit rules are returned, otherwise, creation rules are.
     *
     * @return array The validation rules array
     */
    public function getValidationRules()
    {
        return $this->exists ? $this->getEditRules() : $this->getCreateRules();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Ghunti\LaravelBase\Eloquent\BaseBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new BaseBuilder($query);
    }

    /**
     * Return the creation rules for the current model
     *
     * @return array The validation rules array
     */
    abstract protected function getCreateRules();

    /**
     * Return the edition rules for the current model
     *
     * @return array The validation rules array
     */
    abstract protected function getEditRules();
}
