<?php

namespace Sandyandi\ElasticQb\Tests\Queries\Compound\Boolean;

use Sandyandi\ElasticQb\Queries\Compound\Boolean\Boolean;
use Sandyandi\ElasticQb\Tests\CreatesTerm;

class BooleanTest extends \PHPUnit_Framework_TestCase
{
    use CreatesTerm;

    /**
     * @test
     */
    public function shouldBuildSingleBoolQuery()
    {
        $boolean = new Boolean();
        $actual = $boolean->appendToMust($this->createTerm('firstName', 'Sandyandi'))
            ->getQuery();

        $expected = [
            'bool' => [
                'must' => [
                    'term' => [
                        'firstName' => 'Sandyandi'
                    ]
                ]
            ]
        ];

        static::assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldBuildMultipleBoolQueries()
    {
        $boolean = new Boolean();
        $actual = $boolean
            ->appendToMust($this->createTerm('firstName', 'Sandyandi'))
            ->appendToMustNot($this->createTerm('lastName', 'dela Cruz'))
            ->appendToShould($this->createTerm('birthDate', '1986-08-17'))
            ->getQuery();

        $expected = [
            'bool' => [
                'must' => [
                    'term' => [
                        'firstName' => 'Sandyandi'
                    ]
                ],
                'must_not' => [
                    'term' => [
                        'lastName' => 'dela Cruz'
                    ]
                ],
                'should' => [
                    'term' => [
                        'birthDate' => '1986-08-17'
                    ]
                ]
            ]
        ];

        static::assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldBuildNestedBoolQueries()
    {
        $nestedBoolean = new Boolean();
        $nestedBoolean
            ->appendToShould($this->createTerm('nestOne', 'Boolean Query'))
            ->appendToShould($this->createTerm('nestTwo', 'Another Boolean Query'));
        $boolean = new Boolean();
        $actual = $boolean
            ->appendToMust($this->createTerm('firstName', 'Sandyandi'))
            ->appendToMustNot($this->createTerm('lastName', 'dela Cruz'))
            ->appendToShould($this->createTerm('birthDate', '1986-08-17'))
            ->appendToMust($nestedBoolean)
            ->getQuery();

        $expected = [
            'bool' => [
                'must' => [
                    [
                        'term' => [
                            'firstName' => 'Sandyandi',
                        ],
                    ],
                    [
                        'bool' => [
                            'should' => [
                                [
                                    'term' => [
                                        'nestOne' => 'Boolean Query',
                                    ],
                                ],
                                [
                                    'term' => [
                                        'nestTwo' => 'Another Boolean Query',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'must_not' => [
                    'term' => [
                        'lastName' => 'dela Cruz'
                    ]
                ],
                'should' => [
                    'term' => [
                        'birthDate' => '1986-08-17'
                    ]
                ]
            ]
        ];

        static::assertEquals($expected, $actual);
    }
}
