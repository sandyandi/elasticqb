<?php

namespace Sandyandi\ElasticQb\Queries\Leaf;

class Factory
{
    private function __construct() {}
    private function __clone() {}

    /**
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Factory
     */
    public static function getInstance()
    {
        static $instance;

        if (! $instance instanceof Factory) {
            $instance = new static;
        }

        return $instance;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function match($key, $value)
    {
        return $this->createLeaf('match', $key, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function matchPhrase($key, $value)
    {
        return $this->createLeaf('match_phrase', $key, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function matchPhrasePrefix($key, $value)
    {
        return $this->createLeaf('match_phrase_prefix', $key, $value);
    }

    /**
     * @param array $keys
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\MultiMatch
     */
    public function multiMatch($keys, $value)
    {
        return new MultiMatch($keys, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function commonTerms($key, $value)
    {
        return $this->createLeaf('common', $key, $value);
    }

    /**
     * @param mixed $value
     * @param array $keys
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\QueryString
     */
    public function queryString($value, $keys = [])
    {
        return new QueryString($value, $keys);
    }

    /**
     * @param mixed $value
     * @param array $keys
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\QueryString
     */
    public function simpleQueryString($value, $keys = [])
    {
        return new QueryString($value, $keys, true);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function term($key, $value)
    {
        return $this->createLeaf('term', $key, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function terms($key, $value)
    {
        return $this->createLeaf('terms', $key, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function range($key, $value)
    {
        return $this->createLeaf('range', $key, $value);
    }

    /**
     * @param string $key
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Exists
     */
    public function exists($key)
    {
        return new Exists($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function prefix($key, $value)
    {
        return $this->createLeaf('prefix', $key, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function wildcard($key, $value)
    {
        return $this->createLeaf('wildcard', $key, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function regexp($key, $value)
    {
        return $this->createLeaf('regexp', $key, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    public function fuzzy($key, $value)
    {
        return $this->createLeaf('fuzzy', $key, $value);
    }

    /**
     * @param string $type
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Type
     */
    public function type($type)
    {
        return new Type($type);
    }

    /**
     * @param array $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Ids
     */
    public function ids($value)
    {
        return new Ids($value);
    }

    /**
     * @param string $query
     * @param string $key
     * @param mixed $value
     *
     * @return \Sandyandi\ElasticQb\Queries\Leaf\Leaf
     */
    protected function createLeaf($query, $key, $value)
    {
        return new Leaf($query, $key, $value);
    }
}
