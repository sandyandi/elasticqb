<?php

namespace Sandyandi\ElasticQb\Queries\Compound\Boolean;

use Sandyandi\ElasticQb\Contracts\QueryContract;
use Sandyandi\ElasticQb\Queries\Leaf\Factory as LeafFactory;

class Facade implements QueryContract
{
    /**
     * @var \Sandyandi\ElasticQb\Queries\Leaf\Factory
     */
    protected $leafFactory;

    /**
     * @var \Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean
     */
    protected $boolean;

    public function __construct()
    {
        $this->leafFactory = LeafFactory::getInstance();
        $this->boolean = new Boolean();
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    public function mustTerm($key, $value)
    {
        $this->boolean->appendToMust(
            $this->leafFactory->term($key, $value)
        );

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    public function mustMatch($key, $value)
    {
        $this->boolean->appendToMust(
            $this->leafFactory->match($key, $value)
        );

        return $this;
    }

    /**
     * @param \Closure $closure
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    public function must(\Closure $closure)
    {
        $this->boolean->appendToMust(
            $this->getClosureProcessedInstance($closure)
        );

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    public function mustNotTerm($key, $value)
    {
        $this->boolean->appendToMustNot(
            $this->leafFactory->term($key, $value)
        );

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    public function mustNotMatch($key, $value)
    {
        $this->boolean->appendToMustNot(
            $this->leafFactory->match($key, $value)
        );

        return $this;
    }

    /**
     * @param \Closure $closure
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    public function mustNot(\Closure $closure)
    {
        $this->boolean->appendToMustNot(
            $this->getClosureProcessedInstance($closure)
        );

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    public function shouldTerm($key, $value)
    {
        $this->boolean->appendToShould(
            $this->leafFactory->term($key, $value)
        );

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    public function shouldMatch($key, $value)
    {
        $this->boolean->appendToShould(
            $this->leafFactory->match($key, $value)
        );

        return $this;
    }

    /**
     * @param \Closure $closure
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    public function should(\Closure $closure)
    {
        $this->boolean->appendToShould(
            $this->getClosureProcessedInstance($closure)
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return $this->boolean->getQuery();
    }

    /**
     * @param \Closure $closure
     *
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    protected function getClosureProcessedInstance(\Closure $closure)
    {
        $facade = $this->newInstance();

        $closure($facade);

        return $facade;
    }

    /**
     * @return \Sandyandi\ElasticQb\Queries\Compound\Boolean\Facade
     */
    protected function newInstance()
    {
        return new static($this->leafFactory);
    }
}
