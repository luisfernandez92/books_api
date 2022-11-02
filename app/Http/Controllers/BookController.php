<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'author' => 'required',
            'year' => 'required'
        ]);

        $book = new Book;
        $book->title = $request->title;
        $book->category = $request->category;
        $book->author = $request->author;
        $book->year = $request->year;
        $book->save();

        return $book;
    }

    public function show(Book $book)
    {
        return $book;
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'author' => 'required',
            'year' => 'required'
        ]);

        $book->title = $request->title;
        $book->category = $request->category;
        $book->author = $request->author;
        $book->year = $request->year;
        $book->save();

        return $book;
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();
    }
}
