<?php

namespace GIS\CategoryProduct\Interfaces;

use ArrayAccess;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use JsonSerializable;
use Stringable;
interface SpecificationValueInterface extends Arrayable, ArrayAccess, CanBeEscapedWhenCastToString, HasBroadcastChannel,
    Jsonable, JsonSerializable, QueueableEntity, Stringable, UrlRoutable
{
    public function product(): BelongsTo;
    public function category(): BelongsTo;
    public function specification(): BelongsTo;
    public function color(): HasOne;
}
