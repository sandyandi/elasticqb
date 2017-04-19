<?php

namespace Sandyandi\ElasticQb\Queries\Leaf;

use Sandyandi\ElasticQb\Contracts\QueryContract;

class Exists implements QueryContract
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return ['exists' => ['field' => $this->key]];
    }
}
