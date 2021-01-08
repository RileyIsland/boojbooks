<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Book
 * @package App\Models
 * @property integer $id
 * @property string $author
 * @property string $title
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = ['author', 'title'];
}
