<?php

namespace Sandyandi\Elasticsearch\Tests\Queries\Compound\Boolean;

use Sandyandi\Elasticsearch\Queries\Compound\Boolean\Facade;
use Sandyandi\Elasticsearch\Queries\Leaf\Factory;

class FacadeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Sandyandi\Elasticsearch\Queries\Compound\Boolean\Facade
     */
    private $facade;

    public function setUp()
    {
        $this->facade = new Facade(new Factory());
    }

    /**
     * @test
     */
    public function shouldBuildSingleBoolMustTermQuery()
    {
        $actual = $this->facade
            ->mustTerm('firstName', 'Sandyandi')
            ->getQueryArray();

        $expected = [
            'bool' => [
                'must' => [
                    'term' => [
                        'firstName' => 'Sandyandi',
                    ],
                ],
            ],
        ];

        static::assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldBuildMultipleBoolMustTermQuery()
    {
        $actual = $this->facade
            ->mustTerm('firstName', 'Sandyandi')
            ->mustTerm('lastName', 'dela Cruz')
            ->getQueryArray();

        $expected = [
            'bool' => [
                'must' => [
                    [
                        'term' => [
                            'firstName' => 'Sandyandi',
                        ],
                    ],
                    [
                        'term' => [
                            'lastName' => 'dela Cruz',
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
    public function shouldBuildOneLevelNestedBoolQueries()
    {
        $actual = $this->facade
            ->mustTerm('firstName', 'Sandyandi')
            ->must(function ($facade) {
                $facade->mustNotTerm('lastName', 'dela Cruz');
            })
            ->getQueryArray();

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
                            'must_not' => [
                                'term' => [
                                    'lastName' => 'dela Cruz',
                                ],
                            ],
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
    public function shouldBuildTwoLevelsNestedBoolQueries()
    {
        $actual = $this->facade
            ->mustTerm('firstName', 'Sandyandi')
            ->must(function ($facade) {
                $facade->mustTerm('lastName', 'dela Cruz')
                    ->must(function ($facade) {
                        $facade->mustTerm('birthDate', '1986-08-17');
                    });
            })
            ->getQueryArray();

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
                            'must' => [
                                [
                                    'term' => [
                                        'lastName' => 'dela Cruz',
                                    ],
                                ],
                                [
                                    'bool' => [
                                        'must' => [
                                            'term' => [
                                                'birthDate' => '1986-08-17'
                                            ],
                                        ],
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
