<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(400);
    }


    public function testUserLoginsSuccessfully()
    {
        $payload = ['email' => 'admin@admin.com', 'password' => 'password'];
        $headers = ['Authorization' => "Bearer testing_token_admin"];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200);

    }

    
}
