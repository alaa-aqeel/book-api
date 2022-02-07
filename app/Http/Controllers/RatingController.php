<?php

namespace App\Http\Controllers;

use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    /**
     * Find rating by id and user id or fail 
     * 
     * @param int $bookId 
     * @param int $ratingId 
     * @return \App\Models\Rating|abort 
     */
    public function findRating($bookId, $ratingId) 
    {   
        // find rating by id and userId 
        $rating = Rating::where("id", $ratingId)
                        ->where("user_id", auth()->id())
                        ->where("book_id", $bookId)
                        ->first();
        if (!$rating) 
        {
            abort(response()->json([
                "message" => __("messages.errors.notfound")
            ]));
        }

        return $rating;
    }

    /**
     * Display a listing of the ratings.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $bookId
     * @return \App\Http\Resources\RatingResource
     */
    public function index(Request $request, $bookId)
    {
        $ratings = Rating::where("book_id", $bookId)
                        ->orderBy("created_at", "desc")
                        ->paginate($request->get('limit', 10));

        return RatingResource::collection($ratings);
    }

    /**
     * Store a newly created rating in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $bookId
     * @return App\Http\Resources\RatingResource
     */
    public function store(Request $request, $bookId)
    {
        $request->book = $bookId;
        $validatedData = $request->validate([
            "value" => "required|integer|min:0|max:5",
            "book"  => "exists:books,id",
            "comment" => "nullable|string",
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['book_id'] = $bookId;
        
        $rating = Rating::create($validatedData);

        $response = new RatingResource($rating);
        $response->additional([
            "message" => __("messages.success.create", ["name" => "rating"])
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
    {}

    /**
     * Update the specified rating in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \App\Http\Resources\RatingResource
     */
    public function update(Request $request, $bookId, $ratingId)
    {
        $validatedData = $request->validate([
            "value" => "integer|min:0|max:5",
            "comment" => "nullable|string",
        ]);


        $rating = $this->findRating($bookId, $ratingId);
        $rating->update($validatedData);

        $response = new RatingResource($rating);
        $response->additional([
            "message" => __("messages.success.update", ["name" => "rating "])
        ]);
        return $response;
    }

    /**
     * Remove the specified rating from storage.
     *
     * @param  int  $bookId
     * @param  int  $ratingId
     * @return \Illuminate\Http\Response
     */
    public function destroy($bookId, $ratingId)
    {
        $rating = $this->findRating($bookId, $ratingId);
        $rating->delete();

        return response()->json([
            "message" => __("messages.success.delete", ["name" => "rating"])
        ]);
    }
}
