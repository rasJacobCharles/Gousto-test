<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utility;

use App\Utility\ArrayCollectionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ArrayCollectionTest extends TestCase
{
    use ArrayCollectionTrait;

    public function testFailureToIdInCollectionTest(): void
    {
        $collection = new ArrayCollection();

        $this->assertNull($this->getKey(99, $collection));
    }
}
