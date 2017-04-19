<?php

namespace Sandyandi\ElasticQb\Queries\Leaf;

use Sandyandi\ElasticQb\Contracts\QueryContract;

class QueryString implements QueryContract
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var bool
     */
    protected $isSimple;

    /**
     * @param mixed $value
     * @param array $keys
     * @param bool $isSimple
     */
    public function __construct($value, $keys = [], $isSimple = false)
    {
        $this->value = $value;
        if (count($keys) > 0) {
            $this->value['fields'] = $keys;
        }

        $this->isSimple = $isSimple;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        $queryName = ($this->isSimple ? 'simple_' : '') . 'query_string';

        return [$queryName => $this->value];
    }
}
