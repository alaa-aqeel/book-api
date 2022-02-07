<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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
     * Get profile current user 
     * 
     * @return App\Http\Resources\UserResource
     */
    public function getProfile()
    {

        // get user info 
        $user = new UserResource(auth()->user());

        return $user;
    }

    /**
     * Update profile user 
     * 
     * @param  App\Http\\Requests\UserRequest $request 
     * @return App\Http\Resources\UserResource
     */
    public function updateProfile(UserRequest $request)
    {
        $validatedData = $request->validated();

        // make password hash
        $this->hashPassword($validatedData);

        // get user 
        $user = auth()->user();
        // update user 
        $user->update($validatedData);

        $response = new UserResource($user);
        $response->additional([
            "message" => __("messages.success.update", ['name' => "profile"])
        ]);

        return $response;
    }
}
