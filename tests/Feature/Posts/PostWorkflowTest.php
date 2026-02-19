<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use App\Enums\PostStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    /** @test */
    public function author_can_submit_draft_post_for_review()
    {
        $author = User::factory()->author()->create();
        $post = Post::factory()->draft()->for($author)->create();

        $this->actingAs($author)
            ->post(route('posts.submit', $post))
            ->assertRedirect();

        $this->assertEquals(
            PostStatus::Review,
            $post->fresh()->status
        );
    }

    /** @test */
    public function author_cannot_submit_non_draft_post()
    {
        $author = User::factory()->author()->create();
        $post = Post::factory()->review()->for($author)->create();

        $this->actingAs($author)
            ->post(route('posts.submit', $post))
            ->assertForbidden();

        $this->assertEquals(
            PostStatus::Review,
            $post->fresh()->status
        );
    }

    /** @test */
    public function author_cannot_submit_post_that_is_already_in_review()
    {
        $author = User::factory()->author()->create();
        $post = Post::factory()->review()->for($author)->create();

        $this->actingAs($author)
            ->post(route('posts.submit', $post))
            ->assertForbidden();

        $this->assertEquals(
            PostStatus::Review,
            $post->fresh()->status
        );
    }

    /** @test */
    public function editor_cannot_submit_post_for_review()
    {
        $editor = User::factory()->editor()->create();
        $post = Post::factory()->draft()->create();

        $this->actingAs($editor)
            ->post(route('posts.submit', $post))
            ->assertForbidden();

        $this->assertEquals(
            PostStatus::Draft,
            $post->fresh()->status
        );
    }

    /** @test */
    public function editor_can_publish_review_post()
    {
        $editor = User::factory()->editor()->create();
        $post = Post::factory()->review()->for($editor)->create();

        $this->actingAs($editor)
            ->post(route('posts.publish', $post))
            ->assertRedirect();

        $this->assertEquals(
            PostStatus::Published,
            $post->fresh()->status
        );
    }

    /** @test */
    public function editor_cannot_publish_draft_post()
    {
        $editor = User::factory()->editor()->create();
        $post = Post::factory()->draft()->create();

        $this->actingAs($editor)
            ->post(route('posts.publish', $post))
            ->assertForbidden();

        $this->assertEquals(
            PostStatus::Draft,
            $post->fresh()->status
        );
    }

    /** @test */
    public function editor_cannot_publish_already_published_post()
    {
        $editor = User::factory()->editor()->create();
        $post = Post::factory()->published()->create();

        $this->actingAs($editor)
            ->post(route('posts.publish', $post))
            ->assertForbidden();

        $this->assertEquals(
            PostStatus::Published,
            $post->fresh()->status
        );
    }


    /** @test */
    public function admin_can_publish_any_post()
    {
        $admin = Admin::factory()->create();
        $post = Post::factory()->draft()->create();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.posts.publish', $post))
            ->assertRedirect();

        $this->assertEquals(
            PostStatus::Published,
            $post->fresh()->status
        );
    }

    /** @test */
    public function admin_can_publish_post_from_any_state()
    {
        $admin = Admin::factory()->create();

        foreach ([PostStatus::Draft, PostStatus::Review, PostStatus::Published] as $status) {
            $post = Post::factory()->state([
                'status' => $status,
            ])->create();

            $this->actingAs($admin, 'admin')
                ->post(route('admin.posts.publish', $post))
                ->assertRedirect();

            $this->assertEquals(
                PostStatus::Published,
                $post->fresh()->status
            );
        }

    }

    /** @test */
    public function author_cannot_publish_post()
    {
        $author = User::factory()->author()->create();
        $post = Post::factory()->review()->for($author)->create();

        $this->actingAs($author)
            ->post(route('posts.publish', $post))
            ->assertForbidden();

        $this->assertEquals(
            PostStatus::Review,
            $post->fresh()->status
        );

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => PostStatus::Review->value,
        ]);
    }
}
