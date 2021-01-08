<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class BookBookList
 * @package App\Models
 * @property integer $id
 * @property integer $book_id
 * @property integer $book_list_id
 */
class BookBookList extends Pivot
{
    public $incrementing = true;
    public $timestamps = false;
}
