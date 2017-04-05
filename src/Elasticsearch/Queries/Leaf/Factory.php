<?php

namespace Sandyandi\Elasticsearch\Queries\Leaf;

class Factory
{
    const QUERY_TERM = 'term';
    const QUERY_MATCH = 'match';
    const QUERY_MATCH_PHRASE = 'match_phrase';
    
    /**
     * @param string $key
     * @param mixed $value
     *
     * @return Leaf
     */
    public function term($key, $value)
    {
        return $this->createLeaf(static::QUERY_TERM, $key, $value);
    }
// todo: create base match config (like the MultiMatch) QlNkHpa7xGa9
    /**
     * @param string $key
     * @param mixed $value
     *
     * @return Leaf
     */
    public function match($key, $value)
    {
        return $this->createLeaf(static::QUERY_MATCH, $key, $value);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return Leaf
     */
    public function matchPhrase($key, $value)
    {
        return $this->createLeaf(static::QUERY_MATCH_PHRASE, $key, $value);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return Leaf
     */
    public function matchPhrasePrefix($key, $value)
    {
        return $this->createLeaf(static::QUERY_MATCH_PHRASE, $key, $value);
    }

    /**
     * @param string $query
     * @param array $fields
     * @param \Closure $configure
     *
     * @return MultiMatch
     */
    public function multiMatch($query, array $fields, $configure)
    {
        $multiMatch = new MultiMatch($query, $fields);

        $configure($multiMatch);

        return $multiMatch;
    }

    /**
     * @param string $query
     * @param string $key
     * @param mixed $value
     *
     * @return Leaf
     */
    protected function createLeaf($query, $key, $value)
    {
        return new Leaf($query, $key, $value);
    }
}
