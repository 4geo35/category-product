<?php

namespace GIS\CategoryProduct\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface SpecificationColorInterface
{
    public function value(): BelongsTo;
}
