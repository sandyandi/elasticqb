<?php

namespace Sandyandi\ElasticQb\Queries\Compound\Boolean;

use Sandyandi\ElasticQb\Contracts\QueryContract;

class Boolean implements QueryContract
{
    const CONDITION_MUST = 'must';
    const CONDITION_MUST_NOT = 'must_not';
    const CONDITION_SHOULD = 'should';
    const CONDITION_FILTER = 'filter';

    /**
     * @var \Sandyandi\ElasticQb\Contracts\QueryContract[]
     */
    protected $queries = [];

    /**
     * @param \Sandyandi\ElasticQb\Contracts\QueryContract $query
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean
     */
    public function appendToMust(QueryContract $query)
    {
        return $this->addCondition(static::CONDITION_MUST, $query);
    }

    /**
     * @param \Sandyandi\ElasticQb\Contracts\QueryContract $query
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean
     */
    public function appendToMustNot(QueryContract $query)
    {
        return $this->addCondition(static::CONDITION_MUST_NOT, $query);
    }

    /**
     * @param \Sandyandi\ElasticQb\Contracts\QueryContract $query
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean
     */
    public function appendToShould(QueryContract $query)
    {
        return $this->addCondition(static::CONDITION_SHOULD, $query);
    }

    /**
     * @param \Sandyandi\ElasticQb\Contracts\QueryContract $query
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean
     */
    public function appendToFilter(QueryContract $query)
    {
        return $this->addCondition(static::CONDITION_FILTER, $query);
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        $queryArray = [];

        foreach ($this->queries as $condition => $query) {
            $queryArray[$condition] = $query->getQuery();
        }

        return ['bool' => $queryArray];
    }

    /**
     * @param string $condition
     * @param QueryContract $query
     *
     * @return $this
     */
    protected function addCondition($condition, QueryContract $query)
    {
        if (! isset($this->queries[$condition]) or ! $this->queries[$condition] instanceof Condition) {
            $this->queries[$condition] = new Condition();
        }

        $this->queries[$condition]->addQuery($query);

        return $this;
    }
}
