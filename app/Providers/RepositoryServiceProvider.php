<?php

namespace App\Providers;

use App\Repositories\Interfaces\BookListRepositoryInterface;
use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Repositories\Eloquent\BookListRepository;
use App\Repositories\Eloquent\BookRepository;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Eloquent\EloquentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(EloquentRepositoryInterface::class, EloquentRepository::class);
        $this->app->bind(BookListRepositoryInterface::class, BookListRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
    }
}
