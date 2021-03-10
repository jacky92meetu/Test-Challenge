<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['user_type'=>'admin']);
        $this->admin->generateToken();
        $this->manager = User::factory()->create(['user_type'=>'manager']);
        $this->manager->generateToken();
        $this->user = User::factory()->create(['user_type'=>'user']);
        $this->user->generateToken();
    }

    public function testUserCreateFromAdmin()
    {
        $payload = ['name'=>'name1','email'=>'name1@name1.com','password'=>'password','user_type'=>'user'];
        $headers = ['Authorization' => "Bearer ".$this->admin->api_token];

        $this->json('POST', 'api/users', $payload, $headers)
            ->assertStatus(201);

    }

    public function testUserCreateFromManager()
    {
        $payload = ['name'=>'name2','email'=>'name2@name2.com','password'=>'password','user_type'=>'user'];
        $headers = ['Authorization' => "Bearer ".$this->manager->api_token];

        $this->json('POST', 'api/users', $payload, $headers)
            ->assertStatus(403);

    }

    public function testUserCreateFromUser()
    {
        $payload = ['name'=>'name3','email'=>'name3@name3.com','password'=>'password','user_type'=>'user'];
        $headers = ['Authorization' => "Bearer ".$this->user->api_token];

        $this->json('POST', 'api/users', $payload, $headers)
            ->assertStatus(403);

    }

    public function testUserReadFromAdmin()
    {
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->admin->api_token];

        $this->json('GET', 'api/users', $payload, $headers)
            ->assertStatus(200);

    }

    public function testUserReadFromManager()
    {
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->manager->api_token];

        $this->json('GET', 'api/users', $payload, $headers)
            ->assertStatus(403);

    }

    public function testUserReadFromUser()
    {
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->user->api_token];

        $this->json('GET', 'api/users', $payload, $headers)
            ->assertStatus(403);

    }

    public function testUserUpdateFromAdmin()
    {
        $payload = ['user_type'=>'user'];
        $headers = ['Authorization' => "Bearer ".$this->admin->api_token];

        $this->json('PUT', 'api/users/1', $payload, $headers)
            ->assertStatus(200);

    }

    public function testUserUpdateFromManager()
    {
        $payload = ['user_type'=>'user'];
        $headers = ['Authorization' => "Bearer ".$this->manager->api_token];

        $this->json('PUT', 'api/users/1', $payload, $headers)
            ->assertStatus(403);

    }

    public function testUserUpdateFromUser()
    {
        $payload = ['user_type'=>'user'];
        $headers = ['Authorization' => "Bearer ".$this->user->api_token];

        $this->json('PUT', 'api/users/1', $payload, $headers)
            ->assertStatus(403);

    }

    public function testUserDeleteFromUser()
    {
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->user->api_token];

        $this->json('DELETE', 'api/users/1', $payload, $headers)
            ->assertStatus(403);

    }

    public function testUserDeleteFromManager()
    {
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->manager->api_token];

        $this->json('DELETE', 'api/users/1', $payload, $headers)
            ->assertStatus(403);

    }

    public function testUserDeleteFromAdmin()
    {
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->admin->api_token];

        $this->json('DELETE', 'api/users/1', $payload, $headers)
            ->assertStatus(204);

    }
}
