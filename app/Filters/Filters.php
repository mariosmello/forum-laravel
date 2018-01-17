<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;
    protected $builder;

    protected $filters = [];

    /**
     * ThreadFilters constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getFilters()
    {
        return $this->request->only($this->filters);
    }

    /**
     * @param $builder
     */
    public function apply($builder)
    {

        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value)
        {
            if (method_exists($this, $filter) && $value) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }
}