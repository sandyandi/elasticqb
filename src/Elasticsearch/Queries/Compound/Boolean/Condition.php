<?php

namespace Sandyandi\Elasticsearch\Queries\Compound\Boolean;

use Sandyandi\Elasticsearch\Contracts\QueryContract;

class Condition
{
    /**
     * @var \Sandyandi\Elasticsearch\Contracts\QueryContract[]
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
     * @return \Sandyandi\Elasticsearch\Contracts\QueryContract|null
     */
    public function first()
    {
        return $this->count() === 0 ? null : reset($this->queries);
    }

    /**
     * @param \Sandyandi\Elasticsearch\Contracts\QueryContract $query
     *
     * @return $this
     */
    public function addQuery(QueryContract $query)
    {
        $this->queries[] = $query;

        return $this;
    }

    /**
     * @return array
     */
    public function getQueryArray()
    {
        $queries = [];

        if ($this->count() > 1) {
            foreach ($this->queries as $query) {
                $queries[] = $query->getQueryArray();
            }

            return $queries;
        }

        return $this->first()->getQueryArray();
    }
}
