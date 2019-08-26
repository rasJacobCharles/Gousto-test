<?php

declare(strict_types=1);

namespace App\Utility;

use Doctrine\Common\Collections\ArrayCollection;

trait ArrayCollectionTrait
{
    private function getKey(int $id, ArrayCollection $collection): ?int
    {
        foreach ($collection->getKeys() as $key) {
            if ($collection->get($key)->id === $id) {
                return $key;
            }
        }

        return null;
    }
}
