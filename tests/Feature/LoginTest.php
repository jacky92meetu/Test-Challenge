<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class LoginTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['email' => 'admin@admin.com', 'user_type'=>'admin']);
        $this->admin->generateToken();
    }

    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(400);
    }


    public function testUserLoginsSuccessfully()
    {
        $payload = ['email' => 'admin@admin.com', 'password' => 'password'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200);

    }

    
}
