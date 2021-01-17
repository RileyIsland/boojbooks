<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class BookList
 * @package App\Models
 * @property integer $id
 * @property Collection books
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BookList extends BaseModel
{
    use HasFactory;

    /**
     * the Books that belong to the BookList
     * @return BelongsToMany
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->using(BookBookList::class)->withPivot('id');
    }
}
