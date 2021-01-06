<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookList extends Model
{
    use HasFactory;

    /**
     * the Books that belong to the BookList
     * @return BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
