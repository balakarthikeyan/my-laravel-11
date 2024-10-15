<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;
use App\Services\CommentService;

class CommentServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testCreateComment()
    {
        $user = User::create([
          'name' => 'Jhon',
          'email' => 'jhon@gmail.com',
          'password' => 'password'
        ]);

        $service = new CommentService();
        $data = ['title' => 'Test Comment', 'description' => 'This is a test Comment.'];
        
        $post = $service->create($data, $user->id);
        
        $this->assertNotNull($post);
        $this->assertEquals('Test Comment', $post->title);
        $this->assertEquals($user->id, $post->user_id);
    }
}
