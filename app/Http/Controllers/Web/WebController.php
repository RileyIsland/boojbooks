<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class WebController extends Controller
{
    /**
     * Single Page Application - Book List or Book View
     * @return Response
     */
    public function __invoke(): Response
    {
        return response()->view('web.index');
    }
}
