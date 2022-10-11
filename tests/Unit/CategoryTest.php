<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class CategoryTest extends TestCase
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
        $this->user = User::factory()->create();
        $this->withoutMiddleware(Authenticate::class);
    }

    public function test_category_index()
    {
        $this->actingAs($this->user)
               ->get('category')
               ->assertStatus(200);
    }

    public function test_category_show()
    {
        $category = Category::factory()->create();
        $this->actingAs($this->user)
               ->get('/category/' . $category->id)
               ->assertStatus(200)
               ->assertSeeText($category->title);
    }

    public function test_category_store()
    {
        $category = [
            'name' => 'Testing create category with laravel unit test',
            'user_id' => $this->user->id,
        ];

        $response = $this->actingAs($this->user)
                  ->post('category', $category);

        $response->assertRedirect('/category');
    }

    public function test_category_update()
    {
        $data =
        [
            'name' => 'test creat category',
        ];

        $updateData = [
            'name' => 'test update category'
          ];

        $category = Category::factory()->create($data);

        $this->actingAs($this->user)->put('/category/' . $category->id, $updateData)->assertRedirect('/category');
        $this->assertDatabaseMissing('categories', $data);
        $this->assertDatabaseHas('categories', $updateData);
    }

    public function test_category_destroy()
    {
        $category = Category::factory()
                   ->create();

        $this->actingAs($this->user)
               ->delete('/category/' . $category->id)
               ->assertRedirect('/category');

        $this->assertDatabaseMissing('categories', $category->toArray());
    }
}
