<?php

use App\Models\Item;
use Illuminate\Support\Facades\Artisan;

Artisan::command('circular', function () {
    $parent = Item::query()->create();
    $parent->items()->create();
    $parent->items()->create();
    $parent->items()->create();

    $parent->load(['items']);

    // set parent instance manually to create the circular reference
    $parent->items->each->setRelation('item', $parent);

    $this->info($parent->toJson(\JSON_PRETTY_PRINT));

    // print twice to show the visited property is cleared nicely
    $this->info($parent->toJson(\JSON_PRETTY_PRINT));
});
