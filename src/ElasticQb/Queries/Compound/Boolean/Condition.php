<?php

namespace Sandyandi\ElasticQb\Queries\Compound\Boolean;

use Sandyandi\ElasticQb\Contracts\QueryContract;

class Condition implements QueryContract
{
    /**
     * @var \Sandyandi\ElasticQb\Contracts\QueryContract[]
     */
    protected $queries = [];

    /**
     * @return int
     */
    public function count()
    {
        return count($this->queries);
    }

    /**
     * @return \Sandyandi\ElasticQb\Contracts\QueryContract|null
     */
    public function first()
    {
        return $this->count() === 0 ? null : reset($this->queries);
    }

    /**
     * @param \Sandyandi\ElasticQb\Contracts\QueryContract $query
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Condition
     */
    public function addQuery(QueryContract $query)
    {
        $this->queries[] = $query;

        return $this;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        $queries = [];

        if ($this->count() > 1) {
            foreach ($this->queries as $query) {
                $queries[] = $query->getQuery();
            }

            return $queries;
        }

        return $this->first()->getQuery();
    }
}
