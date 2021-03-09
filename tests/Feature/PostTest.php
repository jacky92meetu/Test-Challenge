<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use app\Models\Post;
use app\Models\User;

class PostTest extends TestCase
{
    public function testPostCreateFromAdmin()
    {
        $payload = ['title'=>'admin_post','body'=>'contents'];
        $headers = ['Authorization' => "Bearer testing_token_admin"];

        $this->json('POST', 'api/posts', $payload, $headers)
            ->assertStatus(201);
    }

    public function testPostCreateFromManager()
    {
        $payload = ['title'=>'manager_post','body'=>'contents'];
        $headers = ['Authorization' => "Bearer testing_token_manager"];

        $this->json('POST', 'api/posts', $payload, $headers)
            ->assertStatus(201);
    }

    public function testPostCreateFromUser()
    {
        $payload = ['title'=>'user_post','body'=>'contents'];
        $headers = ['Authorization' => "Bearer testing_token_user"];

        $this->json('POST', 'api/posts', $payload, $headers)
            ->assertStatus(201);
    }

    public function testPostReadFromAdmin()
    {
        $user = User::where('user_type','=','admin')->first();
        $post = Post::factory()->make(['user_id'=>$user->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$user->api_token];

        $this->json('GET', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);
    }

    public function testPostReadFromManager()
    {
        $user = User::where('user_type','=','manager')->first();
        $post = Post::factory()->make(['user_id'=>$user->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$user->api_token];

        $this->json('GET', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);
    }

    public function testPostReadFromUser()
    {
        $user = User::where('user_type','=','user')->first();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$user->api_token];
        
        $user2 = User::factory()->create(['user_type'=>'user']);
        $post2 = Post::factory()->create(['id'=>2,'user_id'=>$user2->id]);
        
        $this->json('GET', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);

        $this->json('GET', 'api/posts/'.$post2->id, $payload, $headers)
            ->assertStatus(403);

    }

    public function testPostUpdateFromAdmin()
    {
        $user = User::where('user_type','=','admin')->first();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $payload = ['title'=>'change_title'];
        $headers = ['Authorization' => "Bearer ".$user->api_token];

        $this->json('PUT', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);
    }

    public function testPostUpdateFromManager()
    {
        $user = User::where('user_type','=','manager')->first();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $payload = ['title'=>'change_title'];
        $headers = ['Authorization' => "Bearer ".$user->api_token];

        $this->json('PUT', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);
    }

    public function testPostUpdateFromUser()
    {
        $user = User::where('user_type','=','user')->first();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $payload = ['title'=>'change title'];
        $headers = ['Authorization' => "Bearer ".$user->api_token];
        
        $user2 = User::factory()->create(['user_type'=>'user']);
        $post2 = Post::factory()->create(['id'=>2,'user_id'=>$user2->id]);
        
        $this->json('PUT', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);

        $this->json('PUT', 'api/posts/'.$post2->id, $payload, $headers)
            ->assertStatus(403);

    }
    
    public function testPostDeleteFromAdmin()
    {
        $user = User::where('user_type','=','admin')->first();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$user->api_token];

        $this->json('DELETE', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(204);
    }

    public function testPostDeleteFromManager()
    {
        $user = User::where('user_type','=','manager')->first();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$user->api_token];

        $this->json('DELETE', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(204);
    }

    public function testPostDeleteFromUser()
    {
        $user = User::where('user_type','=','user')->first();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$user->api_token];
        
        $user2 = User::factory()->create(['user_type'=>'user']);
        $post2 = Post::factory()->create(['id'=>2,'user_id'=>$user2->id]);
        
        $this->json('DELETE', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(204);

        $this->json('DELETE', 'api/posts/'.$post2->id, $payload, $headers)
            ->assertStatus(403);

    }
}
