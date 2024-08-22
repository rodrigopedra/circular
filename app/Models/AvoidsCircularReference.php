<?php

namespace App\Models;

use App\Visited;

trait AvoidsCircularReference
{
    // recursion flag
    protected $visited = false;

    public function toArray(): array
    {
        if ($this->visited) {
            return [Visited::VISITED];
        }

        $this->visited = true;

        try {
            return parent::toArray();
        } finally {
            $this->visited = false;
        }
    }

    public function relationsToArray(): array
    {
        return \array_filter(parent::relationsToArray(), fn ($item) => $item !== [Visited::VISITED]);
    }
}
