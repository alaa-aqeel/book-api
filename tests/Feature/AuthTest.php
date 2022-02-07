<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{

    /**
     * Test data for user 
     */
    public $userData = [
        "email" => "test@email.com",
        "password" => "12345678",
        "fullname" => "test account"
    ];


    /**
     * Test register new account 
     * 
     * @return void 
     */
    public function test_register() 
    {
        $response = $this->postJson("/api/v1/auth/register", $this->userData);

        $response->assertStatus(201);

        $response->assertJson([
            "message" => __("messages.sucess.register")
        ]);
    }


    /**
     * Test login and create access token.
     *
     * @return void
     */
    public function test_login()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            "email" => "alaa@email.com",
            "password" => "12345678"
        ]);

        // dd($response);
        $response->assertStatus(200);
        // check access token 
        $response->assertJson(fn (AssertableJson $json) => $json->has("token"));
    }
}
