<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    /** @test */
    public function editor_can_view_posts_index()
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $response = $this->actingAs($editor)
            ->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    /** @test */
    public function author_can_view_posts_index()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $response = $this->actingAs($author)
            ->get(route('posts.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_view_posts_index()
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')
            ->get(route('posts.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function normal_user_cannot_view_posts_index()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)
            ->get(route('posts.index'));

        $response->assertForbidden();
    }

    /** @test */
    public function guest_is_redirected_to_login()
    {
        $response = $this->get(route('posts.index'));

        $response->assertRedirect(route('login'));
    }
}
