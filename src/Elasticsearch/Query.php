<?php

namespace Sandyandi\Elasticsearch;

use Sandyandi\Elasticsearch\Queries\Compound\Boolean\Facade as BooleanFacade;
use Sandyandi\Elasticsearch\Queries\Leaf\Factory as LeafFacade;

class Query
{
    /**
     * @var \Sandyandi\Elasticsearch\Queries\Leaf\Factory
     */
    protected $leafFacade;

    /**
     * @var \Sandyandi\Elasticsearch\Queries\Compound\Boolean\Facade
     */
    protected $booleanFacade;

    /**
     * @var \Sandyandi\Elasticsearch\Contracts\QueryContract[]
     */
    protected $queries = [];

    public function __construct()
    {
        $this->leafFacade = new LeafFacade();
        $this->booleanFacade = new BooleanFacade($this->leafFacade);
    }

    /**
     * @param string $method
     * @param array $parameters
     *
     * @return \Sandyandi\Elasticsearch\Query
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        $facade = null;
        if (method_exists($this->leafFacade, $method)) {
            $facade = $this->leafFacade;
        } elseif (method_exists($this->booleanFacade, $method)) {
            $facade = $this->booleanFacade;
        }

        if ($facade !== null) {
            $this->queries[] = call_user_func_array([$facade, $method], $parameters);

            return $this;
        }

        $className = static::class;

        throw new \BadMethodCallException('Call to undefined method ' . $className . '::' . $method . '()');
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $queryArray = [];

        foreach ($this->queries as $query) {
            $queryArray += $query->getQueryArray();
        }

        return ['query' => $queryArray];
    }
}
