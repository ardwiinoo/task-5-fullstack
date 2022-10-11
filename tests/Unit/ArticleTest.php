<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    // use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->withoutMiddleware(Authenticate::class);
    }


    public function test_article_index()
    {
        $this->actingAs($this->user)
            ->get('/article')->assertStatus(200);
    }

     public function test_article_show()
     {
         $article = Article::factory()
                    ->create();

         $this->actingAs($this->user)
                ->get('/article/' . $article->id)
                ->assertStatus(200)
                ->assertSeeText($article->title)
                ->assertSeeText($article->content);
     }

     public function test_article_store()
     {
         $article = Article::factory()->create();

         $response = $this->actingAs($this->user)
                   ->post('/article', $article->toArray());

         $response->assertRedirect('/');
     }

     public function test_article_update()
     {
         $oldData = [
             'title' => 'Ini artikel buat create',
             'image' => null,
             'category_id'=> 2,
             'user_id' => $this->user->id,
             'content' => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac velit sit amet nulla dignissim convallis in non velit. Vestibulum id odio odio. Donec vel magna lobortis, blandit elit quis, imperdiet mi. Vestibulum posuere magna id finibus pharetra. Sed eu augue egestas, tempor purus quis, porta magna. Nunc consequat cursus luctus. Sed at nunc risus. Nulla nec odio enim. Suspendisse vestibulum libero sed velit congue pretium. Maecenas sit amet suscipit dolor.'
         ];

         $newData = [
             'title' => 'Ini artikel buat update',
             'image' => null,
             'category_id'=> 1,
             'user_id' => $this->user->id,
             'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ornare, nisl id ultrices dapibus, purus dui interdum justo, eu lobortis turpis est at nibh. Nam luctus quam in lobortis pretium. Etiam sit amet sodales mi, a aliquet est. Curabitur mi justo, gravida non feugiat eget, efficitur eu nulla. Proin eu congue lacus. Nullam pulvinar ultricies gravida. Duis vehicula augue nec velit sagittis, in molestie mi posuere. Pellentesque efficitur eget tortor vitae tincidunt. Aliquam volutpat ex nec purus porta vehicula. Quisque semper iaculis lectus ut gravida.'
         ];

         $article = Article::factory()->create($oldData);

         $this->actingAs($this->user)->put('/article/' . $article->id, $newData)->assertRedirect('/article');
         $this->assertDatabaseMissing('articles', $oldData);
         $this->assertDatabaseHas('articles', $newData);
     }

     public function test_article_destroy()
     {
         $article = Article::factory()
                    ->create();

         $this->actingAs($this->user)->delete('/article/' . $article->id)
                ->assertRedirect('/article');

         $this->assertDatabaseMissing('articles', $article->toArray());
     }
}
