<?php

namespace Mtkh\Repo\Filters;


use Illuminate\Database\Eloquent\Builder;

abstract class BaseFilter implements BaseFilterContract
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * BaseFilter constructor.
     *
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }
}
