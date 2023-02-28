<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @group posts
     * A basic feature test example.
     */
    public function test_show_posts()
    {
        $user = User::factory()->create();
        $posts = Post::factory()->count(3)->create(['user_id' => $user->id]);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('posts');
        $response->assertSeeText($posts->first()->title);
    }


    /**
     * @group posts
     */
    public function test_forbidden_delete()
    {
        $user = User::factory()->create();
        $another_user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this->actingAs($another_user);
        $response = $this->delete('/posts/' . $post->id);
        $response->assertForbidden();
    }

}
