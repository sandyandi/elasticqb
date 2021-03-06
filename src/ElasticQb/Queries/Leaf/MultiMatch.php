<?php

namespace Sandyandi\ElasticQb\Queries\Leaf;

use Sandyandi\ElasticQb\Contracts\QueryContract;

class MultiMatch implements QueryContract
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param array $keys
     * @param mixed $value
     */
    public function __construct($keys, $value)
    {
        $this->value = $value;
        $this->value['fields'] = $keys;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return ['multi_match' => $this->value];
    }
}
