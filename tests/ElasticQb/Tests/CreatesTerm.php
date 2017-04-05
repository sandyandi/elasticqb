<?php

namespace Sandyandi\ElasticQb\Tests;

use Sandyandi\ElasticQb\Queries\Leaf\Term;

trait CreatesTerm
{
    protected function createTerm($key, $value)
    {
        return new Term($key, $value);
    }
}
