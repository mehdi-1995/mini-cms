<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostEditTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    /** @test */
    public function editor_can_edit_any_post()
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $post = Post::factory()->create();

        $response = $this->actingAs($editor)
        ->get(route('posts.edit', $post));

        $response->assertOk();
        $response->assertViewIs('posts.edit');
    }

    /** @test */
    public function author_can_edit_own_post()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $post = Post::factory()->create([
            'user_id' => $author->id,
        ]);

        $response = $this->actingAs($author)
        ->get(route('posts.edit', $post));

        $response->assertOk();
    }

    /** @test */
    public function author_cannot_edit_other_post()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $post = Post::factory()->create();

        $response = $this->actingAs($author)
        ->get(route('posts.edit', $post));

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_edit_any_post()
    {
        $admin = Admin::factory()->create();

        $post = Post::factory()->create();

        $response = $this->actingAs($admin, 'admin')
            ->get(route('admin.posts.edit', $post));

        $response->assertOk();
        $response->assertViewIs('posts.edit');
    }

    /** @test */
    public function normal_user_cannot_edit_posts()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $post = Post::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('posts.edit', $post));

        $response->assertForbidden();
    }

    /** @test */
    public function guest_is_redirected_to_login()
    {
        $post = Post::factory()->create();
        $response = $this->get(route('posts.edit', $post));
        $response->assertRedirect(route('login'));
    }
}
