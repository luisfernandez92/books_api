<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_all_books()
    {
        $books = Book::factory(4)->create();
        
        $this->getJson(route('books.index'))
                        ->assertJsonFragment([
                            'title' => $books[0]->title,
                            'category' => $books[0]->category,
                            'author' => $books[0]->author,
                        ])->assertJsonFragment([
                            'title' => $books[1]->title,
                            'category' => $books[1]->category,
                            'author' => $books[1]->author,
                        ]);
    }

    /** @test */
    function can_get_one_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson(route('books.show', $book))
                        ->assertJsonFragment([
                            'title' => $book->title
                        ]);
    }

    /** @test */
    function can_create_books()
    {
        $this->postJson(route('books.store'), [])
             ->assertJsonValidationErrorFor('title');

        $this->postJson(route('books.store'), [
            'title' => 'My new book',
            'category' => 'Terror',
            'author' => 'Pancrasio',
            'year' => 2022
        ])->assertJsonFragment([
            'title' => 'My new book',
            'category' => 'Terror',
            'author' => 'Pancrasio',
            'year' => 2022
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'My new book',
            'category' => 'Terror',
            'author' => 'Pancrasio',
            'year' => 2022
        ]);
    }

    /** @test */
    function can_update_books()
    {
        $book = Book::factory()->create();

        $this->patchJson(route('books.update', $book), [])
             ->assertJsonValidationErrorFor('title');

        $this->patchJson(route('books.update', $book), [
            'title' => 'Edited book',
            'category' => 'Edited Terror',
            'author' => 'Edited Pancrasio',
            'year' => 2022
        ])->assertJsonFragment([
            'title' => 'Edited book',
            'category' => 'Edited Terror',
            'author' => 'Edited Pancrasio',
            'year' => 2022
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Edited book',
            'category' => 'Edited Terror',
            'author' => 'Edited Pancrasio',
            'year' => 2022
        ]);
    }

    /** @test */
    function can_delete_books()
    {
        $book = Book::factory()->create();

        $this->deleteJson(route('books.destroy', $book))
             ->assertNoContent();

        $this->assertDatabaseCount('books', 0);
    }
}
