<?php

namespace Sandyandi\ElasticQb\Queries\Leaf;

use Sandyandi\ElasticQb\Contracts\QueryContract;

class Ids implements QueryContract
{
    /**
     * @var array
     */
    protected $value;

    /**
     * @param array $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return ['ids' => $this->value];
    }
}
