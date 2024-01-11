<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all books
        $query = Book::select("books.id as id","books.filiere as filiere","books.title as title", "books.year as year", "books.pdfLink as pdfLink");
        if($request->has("keyword")){
            $query->join("authors","authors.book_id","=","books.id")
            ->join("users","users.id","=","authors.user_id")
            ->where("users.noms","like","%".$request->keyword."%")
            ->orWhere("books.title","like","%".$request->keyword."%")
            ->orWhere("books.year","like","%".$request->keyword."%")
            ->orWhere("books.filiere","like","%".$request->keyword."%");
        }
       


        $books= $query->get();

        $books->load("authors");

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
            'year' => 'required',
            'filiere' => 'required',
            'authors' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                "errors" => $validator->errors()->getMessages()
            ],411);
        }

        DB::beginTransaction();

        $path = $request->file("pdf")->store("public");

        // Create a new book
        $book = Book::create([
            'title' => $request->title,
            'year' => $request->year,
            'filiere' =>$request->filiere,
            'pdfLink' => url($path)
        ]);
        
        // Authors
        foreach (explode(";",$request->authors) as $noms) {
          $author = User::where("noms",$noms)->first();
          if($author != null){
            Author::create([
                "book_id" => $book->id,
                "user_id" => $author->id
               ]);
          }else{
            return response()->json([
                "errors" => [
                    "author_not_exist" => "Un des auteurs n'existe pas."
                ]
                ],411);
          }
        }

        DB::commit();

        return response()->json($book, 201);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $authors = Authors::where('name','like',"$query$")->get();

        return response()->json($authors);

        $books = Book::where('title','like',"%$query%")
        ->orWhereHas('authors', function(Builder $authorQuery) use ($query){
            $authorQuery->where('name','like',"%$query%");
        })->get();

        return response()->json($books, 200);
        
    }

    public function destroy($id)
    {
        // Find the book by id and delete
        Book::findOrFail($id)->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
