<?php

namespace Sandyandi\Elasticsearch\Queries\Leaf;

use Sandyandi\Elasticsearch\Contracts\QueryContract;

class MultiMatch implements QueryContract
{
    /**
     * @var array
     */
    protected $multiMatch = [];

    /**
     * @param string $query
     * @param array $fields
     */
    public function __construct($query, array $fields)
    {
        $this
            ->setQuery($query)
            ->setFields($fields);
    }

    /**
     * @param string $query
     *
     * @return $this
     */
    public function setQuery($query)
    {
        $this->multiMatch['query'] = $query;

        return $this;
    }

    /**
     * @param array $fields
     *
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->multiMatch['fields'] = $fields;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->multiMatch['type'] = $type;

        return $this;
    }

    /**
     * @param string $operator
     *
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->multiMatch['operator'] = $operator;

        return $this;
    }


    /**
     * @param string $minimumShouldMatch
     *
     * @return $this
     */
    public function minimumShouldMatch($minimumShouldMatch)
    {
        $this->multiMatch['minimum_should_match'] = $minimumShouldMatch;
        
        return $this;
    }

    /**
     * @param float $tieBreaker
     *
     * @return $this
     */
    public function tieBreaker($tieBreaker)
    {
        $this->multiMatch['tie_breaker'] = $tieBreaker;

        return $this;
    }

    /**
     * @param string $analyzer
     *
     * @return $this
     */
    public function analyzer($analyzer)
    {
        $this->multiMatch['analyzer'] = $analyzer;

        return $this;
    }

    /**
     * @return array
     */
    public function getQueryArray()
    {
        return $this->multiMatch;
    }
}
