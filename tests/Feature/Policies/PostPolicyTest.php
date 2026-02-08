<?php

namespace Tests\Feature\Policies;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    /** @test */
    public function author_can_manage_own_post()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $post = Post::factory()->create([
            'user_id' => $author->id,
        ]);

        $this->assertTrue(Gate::forUser($author)->allows('create', Post::class));
        $this->assertTrue(Gate::forUser($author)->allows('update', $post));
        $this->assertTrue(Gate::forUser($author)->allows('delete', $post));
    }

    /** @test */
    public function author_cannot_update_others_posts()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $post = Post::factory()->create(); // مال یکی دیگه

        $this->assertFalse(Gate::forUser($author)->allows('update', $post));
        $this->assertFalse(Gate::forUser($author)->allows('delete', $post));
    }


    /** @test */
    public function editor_can_manage_all_posts()
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $post = Post::factory()->create();

        $this->assertTrue(Gate::forUser($editor)->allows('create', Post::class));
        $this->assertTrue(Gate::forUser($editor)->allows('update', $post));
        $this->assertTrue(Gate::forUser($editor)->allows('delete', $post));
    }

    /** @test */
    public function normal_user_cannot_manage_posts()
    {
        $user = User::factory()->create();

        $post = Post::factory()->create();

        $this->assertFalse(Gate::forUser($user)->allows('create', Post::class));
        $this->assertFalse(Gate::forUser($user)->allows('update', $post));
        $this->assertFalse(Gate::forUser($user)->allows('delete', $post));
    }

    /** @test */
    public function admin_can_manage_posts()
    {
        $admin = Admin::factory()->create();
        $admin->assignRole('super-admin');
        
        $post = Post::factory()->create();

        $this->assertTrue(Gate::forUser($admin)->allows('create', Post::class));
        $this->assertTrue(Gate::forUser($admin)->allows('update', $post));
        $this->assertTrue(Gate::forUser($admin)->allows('delete', $post));
    }

    /** @test */
    public function only_editor_and_admin_can_update_any_posts()
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $admin = Admin::factory()->create();

        $this->assertFalse(Gate::forUser($author)->allows('updateAny', Post::class));
        $this->assertTrue(Gate::forUser($editor)->allows('updateAny', Post::class));
        $this->assertTrue(Gate::forUser($admin)->allows('updateAny', Post::class));
    }


}
