<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Factory\PaginationFactory;
use App\Model\Recipe;
use Doctrine\Common\Collections\ArrayCollection;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class PaginationFactoryTest extends TestCase
{
    /** @var ArrayCollection */
    private $collection;
    /** @var Router|MockObject */
    private $mockRouter;

    protected function setUp(): void
    {
        $this->mockRouter = $this->createMock(Router::class);
        $this->collection = new ArrayCollection();
        for ($i = 1; $i <= 30; $i++) {
            $this->collection->add((new Recipe())->setId($i)) ;
        }
    }

    /**
     * @dataProvider paginationDataProvider
     */
    public function testSuccessPagination(int $expectePage, array $expectedLinks, int $expectedId): void
    {
        $mockRequest = new Request(['page' => $expectePage]);
        $this->mockRouter
            ->method('generate')
            ->withAnyParameters()
            ->willReturn('/api/v1/recipes');

        $service = new PaginationFactory($this->mockRouter);
        $result = $service->create($this->collection, $mockRequest);

        $this->assertEquals(30, $result->numberOfResult);
        $this->assertEquals($expectePage, $result->pageNumber);
        $this->assertEquals($expectedId, current($result->result)->id);
        $this->assertEquals(10, count($result->result));
        $this->assertEquals($expectedLinks, $result->links);
    }

    public function testPaginationOnPageThatDoesNotExistFailure(): void
    {
        $mockRequest = new Request(['page' => 9]);

        $this->expectException(OutOfRangeCurrentPageException::class);
        $this->expectExceptionMessage('Page "9" does not exist. The currentPage must be inferior to "3"');

        $service = new PaginationFactory($this->mockRouter);
        $service->create($this->collection, $mockRequest);
    }

    public function paginationDataProvider(): array
    {
        return [
            [
                1,
                [
                'self' =>  '/api/v1/recipes',
                'first' => '/api/v1/recipes',
                'last' => '/api/v1/recipes',
                'next' => '/api/v1/recipes',
                ],
                1
            ],
            [
                2,
                [
                    'self' =>  '/api/v1/recipes',
                    'first' => '/api/v1/recipes',
                    'last' => '/api/v1/recipes',
                    'next' => '/api/v1/recipes',
                    'prev' => '/api/v1/recipes'
                ],
                11
            ],
            [
                3,
                [
                    'self' =>  '/api/v1/recipes',
                    'first' => '/api/v1/recipes',
                    'last' => '/api/v1/recipes',
                    'prev' => '/api/v1/recipes'
                ],
                21
            ],
        ];
    }
}
