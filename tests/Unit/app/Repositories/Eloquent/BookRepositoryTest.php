<?php

namespace Tests\Unit\App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Eloquent\BookRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class BookRepositoryTest extends TestCase
{
    const BOOK_ID = 1;

    /** @var Book|LegacyMockInterface|MockInterface */
    private $book;

    /** @var BookRepository */
    private $bookRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->book = Mockery::mock(Book::class);
        $this->bookRepository = new BookRepository($this->book);
    }

    public function testFindOrFail()
    {
        $this->book->shouldReceive('findOrFail')->once()->with(self::BOOK_ID, ['*'])->andReturn($this->book);
        $this->assertEquals($this->book, $this->bookRepository->findOrFail(self::BOOK_ID));
    }

    public function testFindOrFailThrowsException()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->book->shouldReceive('findOrFail')->once()->with(self::BOOK_ID, ['*'])->andThrow(ModelNotFoundException::class);
        $this->bookRepository->findOrFail(self::BOOK_ID);
    }
}
