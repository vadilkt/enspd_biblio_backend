<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        // Retrieve all books
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'title' => 'required',
            'year' => 'required|integer',
            'filiere' => 'required',
            'authors' => 'required|array',
            'pdfLink' => 'required|url',
        ]);

        // Create a new book
        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function destroy($id)
    {
        // Find the book by id and delete
        Book::findOrFail($id)->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
