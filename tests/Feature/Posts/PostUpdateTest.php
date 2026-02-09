<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    /** @test */
    public function editor_can_update_any_post()
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $post = Post::factory()->create();

        $response = $this->actingAs($editor)
            ->put(route('posts.update', $post), $this->validData());

        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'id'      => $post->id,
            'title'   => 'Updated title',
            'content' => 'Updated content',
        ]);
    }

    /** @test */
    public function author_can_update_own_post()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $post = Post::factory()->create([
            'user_id' => $author->id
        ]);

        $response = $this->actingAs($author)
            ->put(route('posts.update', $post), $this->validData());

        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => 'Updated title',
        ]);
    }

    /** @test */
    public function author_cannot_update_other_posts()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $post = Post::factory()->create();

        $response = $this->actingAs($author)
            ->put(route('posts.update', $post), $this->validData());

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_update_any_post()
    {
        $admin = Admin::factory()->create();

        $post = Post::factory()->create();

        $response = $this->actingAs($admin,'admin')
            ->put(route('admin.posts.update', $post), $this->validData());

        $response->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => 'Updated title',
        ]);
    }

    /** @test */
    public function normal_user_cannot_update_posts()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $post = Post::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('posts.update', $post), $this->validData());

        $response->assertForbidden();
    }

    /** @test */
    public function guest_is_redirected_to_login()
    {
        $post = Post::factory()->create();

        $response = $this->put(route('posts.update', $post), $this->validData());

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function validation_error_when_required_fields_missing()
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $response = $this->actingAs($editor)
            ->put(route('posts.update', Post::factory()->create()), []);
            
        $response->assertSessionHasErrors(['title', 'content']);
    }

    public function validData(): array
    {
        return [
            'title'     => 'Updated title',
            'content'   => 'Updated content',
            'published' => false,
        ];
    }
}
