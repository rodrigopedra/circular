<?php

use App\Models\Item;
use Illuminate\Support\Collection;
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

Artisan::command('shared', function () {
    $sharedItem = Item::query()->create();

    $itemA = Item::query()->create();
    $itemA->setRelation('item', $sharedItem);

    $itemB = Item::query()->create();
    $itemB->setRelation('item', $sharedItem);


    $items = Collection::make([$itemA, $itemB]);

    $parent = new Item();
    $parent->setRelation('items', $items);

    $sharedItem->setRelation('items', $items);

    $this->info($parent->toJson(\JSON_PRETTY_PRINT));
});
