<?php

namespace Mtkh\Repo\Filters;


interface BaseFilterContract
{
    /**
     * Apply your filter on the incoming query
     *
     * @param $args
     * @return mixed
     */
    public function handle($args);
}
