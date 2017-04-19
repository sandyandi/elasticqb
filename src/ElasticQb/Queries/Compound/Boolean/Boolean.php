<?php

namespace Sandyandi\ElasticQb\Queries\Compound\Boolean;

use Sandyandi\ElasticQb\Contracts\QueryContract;

class Boolean implements QueryContract
{
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
        return $this->addCondition('must', $query);
    }

    /**
     * @param \Sandyandi\ElasticQb\Contracts\QueryContract $query
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean
     */
    public function appendToMustNot(QueryContract $query)
    {
        return $this->addCondition('must_not', $query);
    }

    /**
     * @param \Sandyandi\ElasticQb\Contracts\QueryContract $query
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean
     */
    public function appendToShould(QueryContract $query)
    {
        return $this->addCondition('should', $query);
    }

    /**
     * @param \Sandyandi\ElasticQb\Contracts\QueryContract $query
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean
     */
    public function appendToFilter(QueryContract $query)
    {
        return $this->addCondition('filter', $query);
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
     * @param \Sandyandi\ElasticQb\Contracts\QueryContract $query
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean
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
