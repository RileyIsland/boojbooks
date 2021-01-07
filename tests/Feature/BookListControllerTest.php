<?php

namespace Tests\Feature;

use DateTime;
use Exception;
use Illuminate\Http\Response;
use Tests\TestCase;

class BookListControllerTest extends TestCase
{
    /** @var DateTime */
    static $now;

    const BOOK_DATA_1 = [
        'author' => 'Test Author 1',
        'title' => 'Test Title 1'
    ];
    const BOOK_DATA_2 = [
        'author' => 'Test Author 2',
        'title' => 'Test Title 2'
    ];
    const BOOK_DATA_3 = [
        'author' => 'Test Author 3',
        'title' => 'Test Title 3'
    ];

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$now = new DateTime();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function testPutBookList(): array
    {
        $response = $this->put('/api/book-list');
        $response->assertStatus(Response::HTTP_CREATED);
        $responseContent = $response->getContent();
        $this->assertJson($responseContent);
        $responseJson = json_decode($responseContent, true);
        $this->assertArrayHasKey('bookList', $responseJson);
        $bookList = $responseJson['bookList'];
        $this->assertIsInt($bookList['id']);
        $this->assertIsString($bookList['created_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['created_at']), 5);
        $this->assertIsString($bookList['updated_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['updated_at']), 5);
        $this->assertArrayNotHasKey('books', $bookList);
        return $bookList;
    }

    /**
     * @depends testPutBookList
     * @param array $previousBookList
     * @throws Exception
     */
    public function testGetBookAfterPutBookList(array $previousBookList): void
    {
        $response = $this->get("/api/book-list/{$previousBookList['id']}");
        $response->assertStatus(Response::HTTP_OK);
        $responseContent = $response->getContent();
        $this->assertJson($responseContent);
        $responseJson = json_decode($responseContent, true);
        $this->assertArrayHasKey('bookList', $responseJson);
        $bookList = $responseJson['bookList'];
        $this->assertIsInt($bookList['id']);
        $this->assertIsString($bookList['created_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['created_at']), 5);
        $this->assertIsString($bookList['updated_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['updated_at']), 5);
        $this->assertIsArray($bookList['books']);
        $this->assertEmpty($bookList['books']);
    }

    /**
     * @depends testPutBookList
     * @param array $previousBookList
     * @return array
     * @throws Exception
     */
    public function testPutBook1(array $previousBookList): array
    {
        $response = $this->put(
            "/api/book-list/{$previousBookList['id']}/book",
            [
                'bookData' => self::BOOK_DATA_1
            ]
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        return $previousBookList;
    }

    /**
     * @depends testPutBook1
     * @param array $previousBookList
     * @return array
     * @throws Exception
     */
    public function testGetBookListAfterPutBook1(array $previousBookList): array
    {
        $response = $this->get("/api/book-list/{$previousBookList['id']}");
        $response->assertStatus(Response::HTTP_OK);
        $responseContent = $response->getContent();
        $this->assertJson($responseContent);
        $responseJson = json_decode($responseContent, true);
        $this->assertArrayHasKey('bookList', $responseJson);
        $bookList = $responseJson['bookList'];
        $this->assertIsInt($bookList['id']);
        $this->assertIsString($bookList['created_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['created_at']), 5);
        $this->assertIsString($bookList['updated_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['updated_at']), 5);
        $this->assertIsArray($bookList['books']);
        $this->assertCount(1, $bookList['books']);
        $this->assertIsInt($bookList['books'][0]['id']);
        $this->assertEquals(
            self::BOOK_DATA_1,
            [
                'author' => $bookList['books'][0]['author'],
                'title' => $bookList['books'][0]['title']
            ]
        );
        return $bookList;
    }

    /**
     * @depends testGetBookListAfterPutBook1
     * @param array $previousBookList
     * @return array
     * @throws Exception
     */
    public function testPutBook2(array $previousBookList): array
    {
        $response = $this->put(
            "/api/book-list/{$previousBookList['id']}/book",
            [
                'bookData' => self::BOOK_DATA_2
            ]
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        return $previousBookList;
    }

    /**
     * @depends testPutBook2
     * @param array $previousBookList
     * @return array
     * @throws Exception
     */
    public function testGetBookListAfterPutBook2(array $previousBookList): array
    {
        $response = $this->get("/api/book-list/{$previousBookList['id']}");
        $response->assertStatus(Response::HTTP_OK);
        $responseContent = $response->getContent();
        $this->assertJson($responseContent);
        $responseJson = json_decode($responseContent, true);
        $this->assertArrayHasKey('bookList', $responseJson);
        $bookList = $responseJson['bookList'];
        $this->assertIsInt($bookList['id']);
        $this->assertIsString($bookList['created_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['created_at']), 5);
        $this->assertIsString($bookList['updated_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['updated_at']), 5);
        $this->assertIsArray($bookList['books']);
        $this->assertCount(2, $bookList['books']);
        $this->assertIsInt($bookList['books'][0]['id']);
        $this->assertEquals(
            self::BOOK_DATA_1,
            [
                'author' => $bookList['books'][0]['author'],
                'title' => $bookList['books'][0]['title']
            ]
        );
        $this->assertIsInt($bookList['books'][1]['id']);
        $this->assertEquals(
            self::BOOK_DATA_2,
            [
                'author' => $bookList['books'][1]['author'],
                'title' => $bookList['books'][1]['title']
            ]
        );
        return $bookList;
    }

    /**
     * @depends testGetBookListAfterPutBook2
     * @param array $previousBookList
     * @return array
     * @throws Exception
     */
    public function testPutBook3(array $previousBookList): array
    {
        $response = $this->put(
            "/api/book-list/{$previousBookList['id']}/book",
            [
                'bookData' => self::BOOK_DATA_3
            ]
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        return $previousBookList;
    }

    /**
     * @depends testPutBook3
     * @param array $previousBookList
     * @return array
     * @throws Exception
     */
    public function testGetBookListAfterPutBook3(array $previousBookList): array
    {
        $response = $this->get("/api/book-list/{$previousBookList['id']}");
        $response->assertStatus(Response::HTTP_OK);
        $responseContent = $response->getContent();
        $this->assertJson($responseContent);
        $responseJson = json_decode($responseContent, true);
        $this->assertArrayHasKey('bookList', $responseJson);
        $bookList = $responseJson['bookList'];
        $this->assertIsInt($bookList['id']);
        $this->assertIsString($bookList['created_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['created_at']), 5);
        $this->assertIsString($bookList['updated_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['updated_at']), 5);
        $this->assertIsArray($bookList['books']);
        $this->assertCount(3, $bookList['books']);
        $this->assertIsInt($bookList['books'][0]['id']);
        $this->assertEquals(
            self::BOOK_DATA_1,
            [
                'author' => $bookList['books'][0]['author'],
                'title' => $bookList['books'][0]['title']
            ]
        );
        $this->assertIsInt($bookList['books'][1]['id']);
        $this->assertEquals(
            self::BOOK_DATA_2,
            [
                'author' => $bookList['books'][1]['author'],
                'title' => $bookList['books'][1]['title']
            ]
        );
        $this->assertIsInt($bookList['books'][2]['id']);
        $this->assertEquals(
            self::BOOK_DATA_3,
            [
                'author' => $bookList['books'][2]['author'],
                'title' => $bookList['books'][2]['title']
            ]
        );
        return $bookList;
    }

    /**
     * @depends testGetBookListAfterPutBook3
     * @param array $previousBookList
     * @return array
     * @throws Exception
     */
    public function testPostBooks(array $previousBookList): array
    {
        $bookId1 = $previousBookList['books'][0]['id'];
        $bookId2 = $previousBookList['books'][1]['id'];
        $bookId3 = $previousBookList['books'][2]['id'];
        $reorderedBookIds = [$bookId3, $bookId1, $bookId2];
        $response = $this->post(
            "/api/book-list/{$previousBookList['id']}/book",
            [
                'bookIds' => $reorderedBookIds
            ]
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        return [$previousBookList, $reorderedBookIds];
    }

    /**
     * @depends testPostBooks
     * @param array $previousTestVariables
     * @return array
     * @throws Exception
     */
    public function testGetBookAfterPostBooks(array $previousTestVariables): array
    {
        list($previousBookList, $reorderedBookIds) = $previousTestVariables;
        $response = $this->get("/api/book-list/{$previousBookList['id']}");
        $response->assertStatus(Response::HTTP_OK);
        $responseContent = $response->getContent();
        $this->assertJson($responseContent);
        $responseJson = json_decode($responseContent, true);
        $this->assertArrayHasKey('bookList', $responseJson);
        $bookList = $responseJson['bookList'];
        $this->assertIsInt($bookList['id']);
        $this->assertIsString($bookList['created_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['created_at']), 5);
        $this->assertIsString($bookList['updated_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['updated_at']), 5);
        $this->assertIsArray($bookList['books']);
        $this->assertCount(3, $bookList['books']);
        $this->assertIsInt($bookList['books'][0]['id']);
        $this->assertEquals(
            array_merge(
                [
                    'id' => $reorderedBookIds[0]
                ],
                self::BOOK_DATA_3
            ),
            [
                'id' => $bookList['books'][0]['id'],
                'author' => $bookList['books'][0]['author'],
                'title' => $bookList['books'][0]['title']
            ]
        );
        $this->assertIsInt($bookList['books'][1]['id']);
        $this->assertEquals(
            array_merge(
                [
                    'id' => $reorderedBookIds[1]
                ],
                self::BOOK_DATA_1
            ),
            [
                'id' => $bookList['books'][1]['id'],
                'author' => $bookList['books'][1]['author'],
                'title' => $bookList['books'][1]['title']
            ]
        );
        $this->assertIsInt($bookList['books'][2]['id']);
        $this->assertEquals(
            array_merge(
                [
                    'id' => $reorderedBookIds[2]
                ],
                self::BOOK_DATA_2
            ),
            [
                'id' => $bookList['books'][2]['id'],
                'author' => $bookList['books'][2]['author'],
                'title' => $bookList['books'][2]['title']
            ]
        );
        return $bookList;
    }

    /**
     * @depends testGetBookAfterPostBooks
     * @param array $previousBookList
     * @return array
     * @throws Exception
     */
    public function testDeleteBook(array $previousBookList): array
    {
        $response = $this->delete("/api/book-list/{$previousBookList['id']}/book/{$previousBookList['books'][1]['id']}");
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        return $previousBookList;
    }

    /**
     * @depends testDeleteBook
     * @param array $previousBookList
     * @throws Exception
     */
    public function testGetBookListAfterDeleteBook(array $previousBookList): void
    {
        $response = $this->get("/api/book-list/{$previousBookList['id']}");
        $response->assertStatus(Response::HTTP_OK);
        $responseContent = $response->getContent();
        $this->assertJson($responseContent);
        $responseJson = json_decode($responseContent, true);
        $this->assertArrayHasKey('bookList', $responseJson);
        $bookList = $responseJson['bookList'];
        $this->assertIsInt($bookList['id']);
        $this->assertIsString($bookList['created_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['created_at']), 5);
        $this->assertIsString($bookList['updated_at']);
        $this->assertEqualsWithDelta(self::$now, new DateTime($bookList['updated_at']), 5);
        $this->assertIsArray($bookList['books']);
        $this->assertCount(2, $bookList['books']);
        $this->assertIsInt($bookList['books'][0]['id']);
        $this->assertEquals(
            self::BOOK_DATA_3,
            [
                'author' => $bookList['books'][0]['author'],
                'title' => $bookList['books'][0]['title']
            ]
        );
        $this->assertIsInt($bookList['books'][1]['id']);
        $this->assertEquals(
            self::BOOK_DATA_2,
            [
                'author' => $bookList['books'][1]['author'],
                'title' => $bookList['books'][1]['title']
            ]
        );
    }
}
