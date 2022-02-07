<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Find Favorite book by id and user id or fail 
     * 
     * @param int $favoriteId 
     * @return \App\Models\Favorite|abort 
     */
    public function findFavorite($favoriteId) 
    {   
        // find rating by id and userId 
        $favorite = Favorite::where("id", $favoriteId)
                        ->where("user_id", auth()->id())
                        ->first();
        if (!$favorite) 
        {
            abort(response()->json([
                "message" => __("messages.errors.notfound")
            ]));
        }

        return $favorite;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $favoriteBooks = Favorite::where('user_id', auth()->id())
                                ->paginate($request->get("limit", 10));

        return FavoriteResource::collection($favoriteBooks);
    }

    /**
     * Store a newly created favorite in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "book" => "required|exists:books,id",
        ]);

        $isBookIn = Favorite::where("book_id", $validatedData['book'])
                        ->where("user_id", auth()->id());

        if (!$isBookIn->first()){
            $favoriteBook = Favorite::create([
                "book_id" => $validatedData['book'],
                "user_id" => auth()->id()
            ]);
        } else {
            $favoriteBook = $isBookIn->first();
        }
        
        $response = new FavoriteResource($favoriteBook);
        $response->additional([
            "message" => __("messages.success.create", ["name" => "favorite"])
        ]);

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {}

    /**
     * Remove the specified favorite from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favoriteBook = $this->findFavorite($id);
        $favoriteBook->delete();

        return response()->json([
            "message" => __("messages.success.delete", ["name" => "favorite"])
        ]);
    }
}
