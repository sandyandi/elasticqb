<?php

namespace Sandyandi\Elasticsearch\Tests;

use Sandyandi\Elasticsearch\KeyValuePair;
use Sandyandi\Elasticsearch\Queries\Leaf\Term;

trait CreatesTerm
{
    protected function createTerm($key, $value)
    {
        return new Term($key, $value);
    }
}
