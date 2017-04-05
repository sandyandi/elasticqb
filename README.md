# elasticqb
Elasticsearch fluent query builder.

## Note
This project is in its very early stage. Not all queries implemented yet but the Proof of Concept is there.

## Usage
You can do a simple leaf query like the following:
```php
use Sandyandi\ElasticQb\Query;

$query = new Query();

$query->term('firstName', 'Sandyandi')->getQuery();
```
The code above will produce the following query:
```php
[
    'query' => [
        'term' => [
            'firstName' => 'Sandyandi',
        ],
    ],
];
```
Or `bool` queries:
```php
use Sandyandi\ElasticQb\Query;

$query = new Query();

$query->mustTerm('firstName', 'Sandyandi')->getQuery();
```
Will produce:
```php
[
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
```
Nested `bool` queries is also possible:
```php
$query
    ->mustTerm('firstName', 'Sandyandi')
    ->should(function ($query) {
        $query
            ->mustMatch('lastName', 'dela Cruz')
            ->mustTerm('birthDate', '1986-08-17');
    })->getQuery();
```
Will produce:
```php
[
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
```

## Todo
* implement other queries.
* implement more dynamic ways of constructing queries.
* implement aggregations.
* implement source filtering.
* implement `getResult` (and everything that's required to execute a query like specifying index and type, etc.) where it uses `elasticsearch-php` package to perform the query and get result.
