<?php

namespace Tests\Unit\App\Repositories\Eloquent;

use App\Models\BookList;
use App\Repositories\Eloquent\BookListRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BookListRepositoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    const BOOK_ATTRIBUTES = [
        'author' => 'Test Author',
        'title' => 'Test Title',
    ];

    const BOOK_ID = 1;

    const BOOK_IDS = [3, 1, 2, 4];

    const BOOK_LIST_ID = 1;

    /** @var BookList|MockObject */
    private $bookList;

    /** @var BookListRepository */
    private $bookListRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookList = Mockery::mock(BookList::class);
        $this->bookListRepository = new BookListRepository($this->bookList);
    }

    public function testAddBook()
    {
        $books = Mockery::mock(BelongsToMany::class);
        $this->bookList->shouldReceive('findOrFail')->once()->with(self::BOOK_LIST_ID)->andReturn($this->bookList);
        $this->bookList->shouldReceive('books')->once()->andReturn($books);
        $books->shouldReceive('attach')->once()->with(self::BOOK_ID)->andReturnNull();
        $this->bookListRepository->addBook(self::BOOK_LIST_ID, self::BOOK_ID);
    }

    public function testAddBookThrowsException()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->bookList->shouldReceive('findOrFail')->once()->with(self::BOOK_LIST_ID, ['*'])->andThrowExceptions([new ModelNotFoundException()]);
        $this->bookList->shouldReceive('books')->never();
        $this->bookListRepository->findOrFail(self::BOOK_LIST_ID);
    }

    public function testFindOrFailWithBooks()
    {
        $builder = Mockery::mock(Builder::class);
        $this->bookList->shouldReceive('with')->once()->andReturn($builder);
        $builder->shouldReceive('findOrFail')->once()->with(self::BOOK_LIST_ID)->andReturn($this->bookList);
        $this->assertEquals($this->bookList, $this->bookListRepository->findOrFailWithBooks(self::BOOK_LIST_ID));
    }

    public function testFindOrFailWithBooksThrowsException()
    {
        $this->expectException(ModelNotFoundException::class);
        $builder = Mockery::mock(Builder::class);
        $this->bookList->shouldReceive('with')->once()->andReturn($builder);
        $builder->shouldReceive('findOrFail')->once()->with(self::BOOK_LIST_ID)->andThrow(ModelNotFoundException::class);
        $this->bookListRepository->findOrFailWithBooks(self::BOOK_LIST_ID);
    }

    public function testRemoveBookById()
    {
        $books = Mockery::mock(BelongsToMany::class);
        $this->bookList->shouldReceive('findOrFail')->once()->with(self::BOOK_LIST_ID)->andReturn($this->bookList);
        $this->bookList->shouldReceive('books')->once()->andReturn($books);
        $books->shouldReceive('detach')->once()->with(self::BOOK_ID);
        $this->bookListRepository->removeBookById(self::BOOK_LIST_ID, self::BOOK_ID);
    }

    public function testRemoveBookByIdThrowsException()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->bookList->shouldReceive('findOrFail')->once()->with(self::BOOK_LIST_ID)->andThrow(ModelNotFoundException::class);
        $this->bookList->shouldReceive('books')->never();
        $this->bookListRepository->removeBookById(self::BOOK_LIST_ID, self::BOOK_ID);
    }

    public function testSetBooksById()
    {
        $books = Mockery::mock(BelongsToMany::class);
        $this->bookList->shouldReceive('findOrFail')->once()->with(self::BOOK_LIST_ID)->andReturn($this->bookList);
        $this->bookList->shouldReceive('books')->once()->andReturn($books);
        $books->shouldReceive('sync')->once()->with([]);
        $books->shouldReceive('sync')->once()->with(self::BOOK_IDS);
        $this->bookListRepository->setBooksById(self::BOOK_LIST_ID, self::BOOK_IDS);
    }

    public function testSetBooksByIdThrowsException()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->bookList->shouldReceive('findOrFail')->once()->with(self::BOOK_LIST_ID)->andThrow(ModelNotFoundException::class);
        $this->bookList->shouldReceive('books')->never();
        $this->bookListRepository->setBooksById(self::BOOK_LIST_ID, self::BOOK_IDS);
    }
}
