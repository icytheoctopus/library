<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * @return BookResource
     */
    public function index()
    {
        return new BookResource(Book::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $book = new Book([
            'name' => $request->get('name'),
            'release_date' => $request->get('release_date')
        ]);

        $book->save();
        return response()->json('success');
    }

    public function createAttach(Request $request){
        $authorArray = $request->get('author');
        $author = Author::find($authorArray['id']);

        $bookArray = $request->get('book');
        $book = new Book([
            'name' => $bookArray['name'],
            'release_date' => $bookArray['release_date'],
        ]);
        $book->save();
        $book->authors()->attach($author);

        return response()->json('successfully attached');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $book = Book::find($id);
        $book->update($request->all());

        return response()->json('successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $book = Book::find($id);
        $book->delete();

        return response()->json('successfully deleted');
    }
}
