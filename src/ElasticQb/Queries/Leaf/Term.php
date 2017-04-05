<?php

namespace Sandyandi\ElasticQb\Queries\Leaf;

use Sandyandi\ElasticQb\Contracts\QueryContract;

class Term implements QueryContract
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $value;

    /**
     * Term constructor.
     *
     * @param string $key
     * @param string $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return [
            'term' => [
                $this->key => $this->value,
            ],
        ];
    }
}
