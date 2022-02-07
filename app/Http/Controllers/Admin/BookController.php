<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{   
    /**
     * Upload image 
     * 
     * @param array $validatedData 
     * @return void 
     */
    function uploadImage(mixed &$validatedData)
    {
        if (isset($validatedData['image'])) {
            $image = $validatedData["image"]->store('public');
            $validatedData["image"] = Storage::url($image);
        }
    }

    /**
     * update section id  
     * 
     * @param array $validatedData 
     * @return void 
     */
    function updateSection(mixed &$validatedData)
    {
        if (isset($validatedData['section'])) {
            $validatedData["section_id"] = $validatedData["section"];
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\BookResource
     */
    public function index(Request $request)
    {

        # filter books by name, author and language 
        $books = Book::where("name", "like", "%".$request->get('name', '')."%")
                        ->where("author", "like", "%".$request->get('author', '')."%")
                        ->where("language", "like", "%".$request->get('language', '')."%");

        $books = $books->paginate($request->get("limit", 8));

        return BookResource::collection($books);
    }

    /**
     * Store a newly created book in storage.
     *
     * @param  \App\Http\Requests\BookRequest  $request
     *  @return \App\Http\Resources\BookResource
     */
    public function store(BookRequest $request)
    {
        $validatedData = $request->validated();

        // upload image and update validateData
        $this->uploadImage($validatedData);
        $this->updateSection($validatedData);
        $book = Book::create($validatedData);

        $response = new BookResource($book);
        $response->additional([
            "message" => __("messages.sucess.create", ["name" => "book"])
        ]);
        return $response;
    }

    /**
     * Display the specified book.
     *
     * @param  int  $id
     * @return \App\Http\Resources\BookResource
     */
    public function show($id)
    {
        $book = $this->findOrfailObject(Book::class, $id);
        
        $response = new BookResource($book);

        return $response;
    }

    /**
     * Update the specified book in storage.
     *
     * @param  \App\Http\Requests\BookRequest  $request
     * @param  int  $id
     * @return \App\Http\Resources\BookResource
     */
    public function update(BookRequest $request, $id)
    {
        $validatedData = $request->validated();

        // upload image and update validateData
        $this->uploadImage($validatedData);
        $this->updateSection($validatedData);
        $book = $this->findOrfailObject(Book::class, $id);
        $book->update($validatedData);

        $response = new BookResource($book);
        $response->additional([
            "message" => __("messages.sucess.update", ["name" => "book"])
        ]);
        return $response;
    }

    /**
     * Remove the specified book from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = $this->findOrfailObject(Book::class, $id);
        $book->delete();

        return response()->json([
            "message" => __("messages.sucess.delete", ["name" => "book"])
        ]);
    }
}
