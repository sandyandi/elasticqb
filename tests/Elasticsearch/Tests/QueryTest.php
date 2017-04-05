<?php

namespace Sandyandi\Elasticsearch\Tests;

use Sandyandi\Elasticsearch\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Sandyandi\Elasticsearch\Query
     */
    private $query;

    public function setUp()
    {
        $this->query = new Query();
    }

    /**
     * @test
     */
    public function shouldBuildLeafQuery()
    {
        $actual = $this->query->term('firstName', 'Sandyandi')->toArray();

        $expected = [
            'query' => [
                'term' => [
                    'firstName' => 'Sandyandi'
                ],
            ],
        ];

        static::assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldBuildBoolQuery()
    {
        $actual = $this->query->mustTerm('firstName', 'Sandyandi')->toArray();

        $expected = [
            'query' => [
                'bool' => [
                    'must' => [
                        'term' => [
                            'firstName' => 'Sandyandi',
                        ],
                    ],
                ],
            ],
        ];

        static::assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldBuildNestedBoolQuery()
    {
        $actual = $this->query
            ->mustTerm('firstName', 'Sandyandi')
            ->should(function ($booleanQuery) {
                $booleanQuery
                    ->mustMatch('lastName', 'dela Cruz')
                    ->mustTerm('birthDate', '1986-08-17');
            })->toArray();

        $expected = [
            'query' => [
                'bool' => [
                    'must' => [
                        'term' => [
                            'firstName' => 'Sandyandi',
                        ],
                    ],
                    'should' => [
                        'bool' => [
                            'must' => [
                                [
                                    'match' => [
                                        'lastName' => 'dela Cruz',
                                    ],
                                ],
                                [
                                    'term' => [
                                        'birthDate' => '1986-08-17',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        static::assertEquals($expected, $actual);
    }
}
