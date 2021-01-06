<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BookList;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WebController extends Controller
{
    private const COOKIE_NAME_BOOK_LIST_ID = 'book_list_id';

    /**
     * Single Page Application - Book List
     * @param Request $request
     * @return Response
     * @throws Exception if there is a problem retrieving the BookList
     */
    public function __invoke(Request $request): Response
    {
        if ($request->hasCookie(self::COOKIE_NAME_BOOK_LIST_ID)) {
            $bookList = BookList::find($request->cookie(self::COOKIE_NAME_BOOK_LIST_ID));
        }
        if (empty($bookList)) {
            $bookList = BookList::create();
        }
        return response()
            ->view(
                'web.index',
                [
                    'bookListId' => $bookList->id
                ]
            )
            ->cookie(self::COOKIE_NAME_BOOK_LIST_ID, $bookList->id, 60);
    }
}
