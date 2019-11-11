<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    /**
     * @return AuthorResource
     */
    public function index()
    {
        return new AuthorResource(Author::all());
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
        $author = new Author([
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'age' => $request->get('age'),
            'address' => $request->get('address')
        ]);

        $author->save();
        return response()->json('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = Author::find($id);
        $author->books = $author->books()->get();
        return response()->json($author);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $author = Author::find($id);
        if ($author){
            $books = Book::all();
            $authorBooks = $author->books()->get();

            return response()->json(['author' => $author, 'authorBooks' => $authorBooks, 'books' => $books]);
        }
        return null;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $author = Author::find($id);
        $author->update($request->all());

        return response()->json('successfully updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $author = Author::find($id);
        $author->delete();

        return response()->json('successfully deleted');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detach($author_id, $book_id)
    {
        $author = Author::find($author_id);
        $book = Author::find($book_id);

        $author->books()->detach($book);

        return response()->json('successfully detached');
    }

    public function attach($author_id, $book_id){
        $author = Author::find($author_id);
        $book = Author::find($book_id);

        $author->books()->attach($book);

        return response()->json('successfully detached');
    }
}
