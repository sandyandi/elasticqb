<?php

namespace Sandyandi\Elasticsearch\Queries\Compound\Boolean;

use Sandyandi\Elasticsearch\Contracts\QueryContract;

class Boolean implements QueryContract
{
    const CONDITION_MUST = 'must';
    const CONDITION_MUST_NOT = 'must_not';
    const CONDITION_SHOULD = 'should';
    const CONDITION_FILTER = 'filter';

    /**
     * @var \Sandyandi\Elasticsearch\Contracts\QueryContract[]
     */
    protected $queries = [];

    /**
     * @param \Sandyandi\Elasticsearch\Contracts\QueryContract $query
     *
     * @return Boolean
     */
    public function appendToMust(QueryContract $query)
    {
        return $this->addCondition(static::CONDITION_MUST, $query);
    }

    /**
     * @param \Sandyandi\Elasticsearch\Contracts\QueryContract $query
     *
     * @return Boolean
     */
    public function appendToMustNot(QueryContract $query)
    {
        return $this->addCondition(static::CONDITION_MUST_NOT, $query);
    }

    /**
     * @param \Sandyandi\Elasticsearch\Contracts\QueryContract $query
     *
     * @return Boolean
     */
    public function appendToShould(QueryContract $query)
    {
        return $this->addCondition(static::CONDITION_SHOULD, $query);
    }

    /**
     * @param \Sandyandi\Elasticsearch\Contracts\QueryContract $query
     *
     * @return Boolean
     */
    public function appendToFilter(QueryContract $query)
    {
        return $this->addCondition(static::CONDITION_FILTER, $query);
    }

    /**
     * @return array
     */
    public function getQueryArray()
    {
        $queryArray = [];

        foreach ($this->queries as $condition => $query) {
            $queryArray[$condition] = $query->getQueryArray();
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
