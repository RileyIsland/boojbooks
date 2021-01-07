<?php

namespace Tests\Feature;

use DateTime;
use Exception;
use Illuminate\Http\Response;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    /** @var DateTime */
    static $now;

    const BOOK_DATA = [
        'author' => 'Test Author',
        'title' => 'Test Title'
    ];

    /** @var int */
    private $bookId;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$now = new DateTime();
    }

    public function setUp(): void
    {
        parent::setUp();
        $bookListId = (int)json_decode($this->put('/api/book-list')->getContent(), true)['bookList']['id'];
        $this->put(
            "/api/book-list/{$bookListId}/book",
            [
                'bookData' => self::BOOK_DATA
            ]
        );
        $this->bookId = (int)json_decode($this->get("/api/book-list/{$bookListId}")->getContent(), true)['bookList']['books'][0]['id'];
    }

    /**
     * @throws Exception
     */
    public function testGetBook(): void
    {
        $response = $this->get("/api/book/{$this->bookId}");
        $response->assertStatus(Response::HTTP_OK);
        $responseContent = $response->getContent();
        $this->assertJson($responseContent);
        $responseJson = json_decode($responseContent, true);
        $this->assertArrayHasKey('book', $responseJson);
        $book = $responseJson['book'];
        $this->assertEquals(
            array_merge(
                [
                    'id' => $this->bookId,
                ],
                self::BOOK_DATA
            ),
            [
                'id' => $book['id'],
                'author' => $book['author'],
                'title' => $book['title']
            ]
        );
        $this->assertIsString($book['created_at']);
        $this->assertIsString($book['updated_at']);
    }
}
