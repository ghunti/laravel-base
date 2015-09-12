<?php

namespace Ghunti\LaravelBase\Eloquent;

use Ghunti\LaravelBase\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class BaseBuilder extends Builder
{
    //@var BaseRepository The repository used for scope querying
    protected $repository;

    /**
     * Dynamically handle calls into the query instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $scopeMethod = 'scope' . ucfirst($method);
        if (method_exists($this->repository, $scopeMethod)) {
            return $this->callRepositoryScope($scopeMethod, $parameters);
        }
        return parent::__call($method, $parameters);
    }

    /**
     * Call the given query scope on the underlying repository.
     *
     * @param  string  $scope
     * @param  array   $parameters
     * @return \Illuminate\Database\Query\Builder
     */
    protected function callRepositoryScope($scope, $parameters)
    {
        array_unshift($parameters, $this);
        return call_user_func_array([$this->repository, $scope], $parameters) ?: $this;
    }

    /**
     * Sets the builders underlying repository
     *
     * @param BaseRepository $repository The repository to set
     */
    public function setRepository(BaseRepository $repository)
    {
        $this->repository = $repository;
    }
}
