<?php

namespace Ghunti\LaravelBase\Interfaces;

interface ModelInterface
{
    /**
    * Save the model to the database.
    *
    * @param array $options
    * @return bool
    */
    public function save(array $options = array());

    /**
    * Save the model and all of its relationships.
    *
    * @return bool
    */
    public function push();

    /**
    * Delete the model from the database.
    *
    * @return bool|null
    */
    public function delete();

    /**
    * Update the model's update timestamp.
    *
    * @return bool
    */
    public function touch();
}
