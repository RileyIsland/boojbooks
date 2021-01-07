<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;

class BookController extends Controller
{
    public function index($bookId)
    {
        $book = Book::findOrFail($bookId);
        return response()->json(
            [
                'book' => $book
            ]
        );
    }
}
