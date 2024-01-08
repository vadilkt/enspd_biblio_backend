<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    public function index()
    {
        // Retrieve all books
        $books = Book::all();
        return response()->json($books);
    }

    public function show(Request $request,Book $book){

        $book = Book::find($request->id);
        $book->load("authors");
        return response()->json($book);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'year' => 'required|integer',
            'filiere' => 'required',
            'authors' => 'required|array',
            'pdfLink' => 'required|url',
        ]);

        if($validator->fails()){
            return response()->json([
                "errors" => $validator->errors()->getMessages()
            ]);
        }

        DB::beginTransaction();

        // Create a new book
        $book = Book::create([
            'title' => $request->title,
            'year' => $request->year,
            'filiere' =>$request->filiere,
            'pdfLink' => $request->pdfLink
        ]);
        
        // Authors
        foreach ($request->authors as $id) {
           Author::create([
            "book_id" => $book->id,
            "user_id" => $id
           ]);
        }

        DB::commit();

        return response()->json($book, 201);
    }

    public function destroy($id)
    {
        // Find the book by id and delete
        Book::findOrFail($id)->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
