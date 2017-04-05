<?php

namespace Sandyandi\ElasticQb;

use Sandyandi\ElasticQb\Contracts\QueryContract;
use Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade as BooleanFacade;
use Sandyandi\ElasticQb\Queries\Leaf\Factory as LeafFacade;

class Query implements QueryContract
{
    /**
     * @var \Sandyandi\ElasticQb\Queries\Leaf\Factory
     */
    protected $leafFacade;

    /**
     * @var \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    protected $booleanFacade;

    /**
     * @var \Sandyandi\ElasticQb\Contracts\QueryContract[]
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
     * @return \Sandyandi\ElasticQb\Query
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
    public function getQuery()
    {
        $queryArray = [];

        foreach ($this->queries as $query) {
            $queryArray += $query->getQuery();
        }

        return ['query' => $queryArray];
    }
}
