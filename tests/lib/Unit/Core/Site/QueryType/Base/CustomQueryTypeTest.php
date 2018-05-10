<?php

namespace Netgen\EzPlatformSiteApi\Tests\Unit\Core\Site\QueryType\Base;

use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\DateMetadata;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\FullText;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalAnd;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator;
use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder\SectionFacetBuilder;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause\SectionIdentifier;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause\SectionName;
use PHPUnit\Framework\TestCase;

/**
 * Custom QueryType test case.
 *
 * @group query-type
 */
class CustomQueryTypeTest extends TestCase
{
    public function testGetName()
    {
        $queryType = $this->getQueryTypeUnderTest();

        $this->assertEquals(
            'Test:Custom',
            $queryType::getName()
        );
    }

    public function testGetSupportedParameters()
    {
        $queryType = $this->getQueryTypeUnderTest();

        $this->assertEquals(
            [
                'content_type',
                'fields',
                'publication_date',
                'sort',
                'limit',
                'offset',
                'modification_date',
            ],
            $queryType->getSupportedParameters()
        );
    }

    public function providerForTestGetQuery()
    {
        return [
            [
                [
                    'modification_date' => 123,
                    'sort' => 'section',
                ],
                new LocationQuery([
                    'filter' => new DateMetadata(
                        DateMetadata::MODIFIED,
                        Operator::EQ,
                        123
                    ),
                    'query' => new FullText('one AND two OR three'),
                    'sortClauses' => [
                        new SectionIdentifier(),
                    ],
                    'facetBuilders' => [
                        new SectionFacetBuilder(),
                    ],
                ]),
            ],
            [
                [
                    'modification_date' => [123, 456],
                    'sort' => [
                        'whatever',
                        'section',
                    ]
                ],
                new LocationQuery([
                    'filter' => new DateMetadata(
                        DateMetadata::MODIFIED,
                        Operator::IN,
                        [123, 456]
                    ),
                    'query' => new FullText('one AND two OR three'),
                    'sortClauses' => [
                        new SectionName(),
                        new SectionIdentifier(),
                    ],
                    'facetBuilders' => [
                        new SectionFacetBuilder(),
                    ],
                ]),
            ],
            [
                [
                    'modification_date' => [
                        'eq' => 123,
                        'in' => [123, 456],
                    ]
                ],
                new LocationQuery([
                    'filter' => new LogicalAnd([
                        new DateMetadata(
                            DateMetadata::MODIFIED,
                            Operator::EQ,
                            123
                        ),
                        new DateMetadata(
                            DateMetadata::MODIFIED,
                            Operator::IN,
                            [123, 456]
                        ),
                    ]),
                    'query' => new FullText('one AND two OR three'),
                    'facetBuilders' => [
                        new SectionFacetBuilder(),
                    ],
                ]),
            ],
        ];
    }

    /**
     * @dataProvider providerForTestGetQuery
     *
     * @param array $parameters
     * @param \eZ\Publish\API\Repository\Values\Content\Query $expectedQuery
     */
    public function testGetQuery(array $parameters, Query $expectedQuery)
    {
        $queryType = $this->getQueryTypeUnderTest();

        $query = $queryType->getQuery($parameters);

        $this->assertEquals(
            $expectedQuery,
            $query
        );
    }

    protected function getQueryTypeUnderTest()
    {
        return new CustomQueryType();
    }
}
