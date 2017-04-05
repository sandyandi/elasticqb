<?php

namespace Sandyandi\Elasticsearch\Queries\Leaf;

use Sandyandi\Elasticsearch\Contracts\QueryContract;

class Leaf implements QueryContract
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $key = '';

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param string $name
     * @param string $key
     * @param mixed $value
     */
    public function __construct($name, $key, $value)
    {
        $this->name = $name;
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getQueryArray()
    {
        return [$this->name => [$this->key => $this->value]];
    }
}
