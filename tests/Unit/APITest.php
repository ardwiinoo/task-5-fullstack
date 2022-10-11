<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Http\Middleware\Authenticate;
use App\Models\Post;

class APITest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        // login
        $this->user = User::factory()->create();
        $this->withoutMiddleware(Authenticate::class);
    }

    public function test_post_index()
    {
        $this->actingAs($this->user)->get('/api/v1/post')->assertStatus(200);
    }

    public function test_post_show()
    {
        $this->actingAs($this->user)->get('/api/v1/post')->assertStatus(200);
    }

      public function test_post_store()
      {
          $post = [
              'title' => 'Testing create post with laravel unit test',
              'image' => null,
              'category_id'=> 1,

              'content' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates in illo quae obcaecati nostrum aut officiis, eius aliquid laudantium iusto repellendus minima, reiciendis nobis labore accusamus quia nihil omnis aspernatur!'
          ];

          $this->actingAs($this->user)->post('/api/v1/post', $post)->assertStatus(201);
      }

    public function test_post_update()
    {
        $data = [
            'title' => 'Testing update post create',
            'image' => null,
            'category_id'=> 2,
            'content' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates in illo quae obcaecati nostrum aut officiis, eius aliquid laudantium iusto repellendus minima, reiciendis nobis labore accusamus quia nihil omnis aspernatur!'
        ];

        $updateData = [
            'title' => 'Testing update post update',
            'image' => null,
            'category_id'=> 1,
            'content' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates in illo quae obcaecati nostrum aut officiis, eius aliquid laudantium iusto repellendus minima, reiciendis nobis labore accusamus quia nihil omnis aspernatur!'
        ];

        $posts = Post::factory()->create($data);

        $this->actingAs($this->user)->put('/api/v1/post/' . $posts->id, $updateData)->assertStatus(201);
    }

    public function test_show_destroy()
    {
        $posts = Post::factory()->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->user)->delete('/api/v1/post/' . $posts->id)->assertStatus(200);
    }
}
