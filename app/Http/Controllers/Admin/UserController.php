<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Make Hash
     * 
     * @param array $validate 
     * @return void 
     */
    private function hashPassword(mixed &$validatedData) 
    {
        // check password index
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
    }

    /**
     * Display a listing of the users.
     *
     * @param \Illuminate\Http\Request $request 
     * @return \App\Http\Resources\UserResource
     */
    public function index(Request $request)
    {
        // args query and limit 
        $query = $request->get("query", "");
        $limit = $request->get("limit", 8);

        // filter users by fullname 
        $users = User::where("fullname", "LIKE", "%{$query}%")
                    ->paginate($limit);

        $response = UserResource::collection($users);
        return $response;
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \App\Http\Resources\UserResource
     */
    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();

        $this->hashPassword($validatedData);
        $user = User::create($validatedData);

        $response = new UserResource($user);
        $response->additional([
            "message" => __("messages.success.create", ["name" => "user"])
        ]);

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id [ user id ]
     * @return \App\Http\Resources\UserResource
     */
    public function show($id)
    {
        $user = $this->findOrfailObject(User::class, $id);
        $response = new UserResource($user);

        return $response;
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  int $id  [ user id ]
     * @return \App\Http\Resources\UserResource
     */
    public function update(UserRequest $request, $id)
    {
        $validatedData = $request->validated();
        
        // update validatedData
        $this->hashPassword($validatedData);
        
        $user = $this->findOrfailObject(User::class, $id);
        $user->update($validatedData);

        $response = new UserResource($user);
        $response->additional([
            "message" => __("messages.success.update", ["name" => "user"])
        ]);

        return $response;
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id [ user id ]
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->findOrfailObject(User::class, $id);
        $user->delete();

        return response()->json([
            "message" => __("messages.success.delete", ["name" => "user"])
        ]);
    }
}
