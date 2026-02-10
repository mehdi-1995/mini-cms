<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    /** @test */
    public function editor_can_delete_any_post()
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $post = Post::factory()->create();

        $response = $this->actingAs($editor)
            ->delete(route('posts.destroy', $post));

        $response->assertRedirect();
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    public function author_can_delete_own_post()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $post = Post::factory()->create([
            'user_id' => $author->id
        ]);

        $response = $this->actingAs($author)
            ->delete(route('posts.destroy', $post));

        $response->assertRedirect();
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    public function author_cannot_delete_other_posts()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $post = Post::factory()->create();

        $response = $this->actingAs($author)
            ->delete(route('posts.destroy', $post));

        $response->assertForbidden();
        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }

    /** @test */
    public function admin_can_delete_any_post()
    {
        $admin = Admin::factory()->create();

        $post = Post::factory()->create();

        $response = $this->actingAs($admin, 'admin')
            ->delete(route('admin.posts.destroy', $post));

        $response->assertRedirect();
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    public function normal_user_cannot_delete_posts()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $post = Post::factory()->create();

        $response = $this->actingAs($user)
                ->delete(route('posts.destroy', $post));

        $response->assertForbidden();

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }

    /** @test */
    public function guest_is_redirected_to_login()
    {
        $post = Post::factory()->create();

        $response = $this->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function published_post_cannot_be_deleted()
    {
        $editor = User::factory()->create()->assignRole('editor');
        $post = Post::factory()->create(['published' => true]);

        $this->actingAs($editor)
            ->delete(route('posts.destroy', $post))
            ->assertSessionHas('error');
    }
}
