<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookBookList extends Pivot
{
    public $incrementing = true;
    public $timestamps = false;
}
