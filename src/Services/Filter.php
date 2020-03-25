<?php


namespace Mtkh\Repo\Services;


use Illuminate\Database\Eloquent\Builder;
use Prophecy\Exception\Doubler\ClassNotFoundException;

class Filter
{
    /**
     * apply all the filters on the query
     *
     * @param Builder $query
     * @param array $filters
     * @param array $validFilters
     * @return Builder
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function apply(Builder $query, array $filters, array $validFilters)
    {
        if (!empty($filters)) {
            $filters = self::prepare($filters, $validFilters);
            foreach ($filters as $key => $value) {
                $className =  self::getPath() . '\\' .$key;
                if (class_exists($className)){
                    $query = app()->make($className, ['builder' => $query])->handle($value);
                } else {
                    throw new ClassNotFoundException("class with $className path, does not exist!", $className);
                }
            }
        }
        return $query;
    }

    /**
     * Sort by priority of application
     *
     * @param $target
     * @param $index_arr
     * @return array
     */
    private static function prepare(&$target, $index_arr)
    {
        $arr_t = array();
        foreach ($index_arr as $key => $value) {
            foreach ($target as $k => $b) {
                if ($k == $value){
                    $arr_t[$k] = $b;
                }
            }
        }
        return $arr_t;
    }

    /**
     * Get the storage of the filters
     *
     * @return mixed
     */
    private static function getPath()
    {
        return config('repository')['filters']['path'];
    }
}
