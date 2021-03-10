<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use app\Models\Post;
use App\Models\User;

class PostTest extends TestCase
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

    public function testPostCreateFromAdmin()
    {
        $payload = ['title'=>'admin_post','body'=>'contents'];
        $headers = ['Authorization' => "Bearer ".$this->admin->api_token];

        $this->json('POST', 'api/posts', $payload, $headers)
            ->assertStatus(201);
    }

    public function testPostCreateFromManager()
    {
        $payload = ['title'=>'manager_post','body'=>'contents'];
        $headers = ['Authorization' => "Bearer ".$this->manager->api_token];

        $this->json('POST', 'api/posts', $payload, $headers)
            ->assertStatus(201);
    }

    public function testPostCreateFromUser()
    {
        $payload = ['title'=>'user_post','body'=>'contents'];
        $headers = ['Authorization' => "Bearer ".$this->user->api_token];

        $this->json('POST', 'api/posts', $payload, $headers)
            ->assertStatus(201);
    }

    public function testPostReadFromAdmin()
    {
        $post = Post::factory()->make(['user_id'=>$this->admin->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->admin->api_token];

        $this->json('GET', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);
    }

    public function testPostReadFromManager()
    {
        $post = Post::factory()->make(['user_id'=>$this->manager->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->manager->api_token];

        $this->json('GET', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);
    }

    public function testPostReadFromUser()
    {
        $post = Post::factory()->create(['user_id'=>$this->user->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->user->api_token];
        
        $user2 = User::factory()->create(['user_type'=>'user']);
        $post2 = Post::factory()->create(['id'=>2,'user_id'=>$user2->id]);
        
        $this->json('GET', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);

        $this->json('GET', 'api/posts/'.$post2->id, $payload, $headers)
            ->assertStatus(403);

    }

    public function testPostUpdateFromAdmin()
    {
        $post = Post::factory()->create(['user_id'=>$this->admin->id]);
        $payload = ['title'=>'change_title'];
        $headers = ['Authorization' => "Bearer ".$this->admin->api_token];

        $this->json('PUT', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);
    }

    public function testPostUpdateFromManager()
    {
        $post = Post::factory()->create(['user_id'=>$this->manager->id]);
        $payload = ['title'=>'change_title'];
        $headers = ['Authorization' => "Bearer ".$this->manager->api_token];

        $this->json('PUT', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);
    }

    public function testPostUpdateFromUser()
    {
        $post = Post::factory()->create(['user_id'=>$this->user->id]);
        $payload = ['title'=>'change title'];
        $headers = ['Authorization' => "Bearer ".$this->user->api_token];
        
        $user2 = User::factory()->create(['user_type'=>'user']);
        $post2 = Post::factory()->create(['id'=>2,'user_id'=>$user2->id]);
        
        $this->json('PUT', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(200);

        $this->json('PUT', 'api/posts/'.$post2->id, $payload, $headers)
            ->assertStatus(403);

    }
    
    public function testPostDeleteFromAdmin()
    {
        $post = Post::factory()->create(['user_id'=>$this->admin->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->admin->api_token];

        $this->json('DELETE', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(204);
    }

    public function testPostDeleteFromManager()
    {
        $post = Post::factory()->create(['user_id'=>$this->manager->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->manager->api_token];

        $this->json('DELETE', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(204);
    }

    public function testPostDeleteFromUser()
    {
        $post = Post::factory()->create(['user_id'=>$this->user->id]);
        $payload = [];
        $headers = ['Authorization' => "Bearer ".$this->user->api_token];
        
        $user2 = User::factory()->create(['user_type'=>'user']);
        $post2 = Post::factory()->create(['id'=>2,'user_id'=>$user2->id]);
        
        $this->json('DELETE', 'api/posts/'.$post->id, $payload, $headers)
            ->assertStatus(204);

        $this->json('DELETE', 'api/posts/'.$post2->id, $payload, $headers)
            ->assertStatus(403);

    }
}
