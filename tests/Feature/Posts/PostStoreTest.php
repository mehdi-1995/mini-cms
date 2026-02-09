<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
use Symfony\Component\Routing\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    /** @test */
    public function editor_can_create_post()
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');
        
        $response = $this->actingAs($editor)
            ->post(Route('posts.store'), $this->validData());
            
        $response->assertRedirect(route('posts.index'));
        
        $this->assertDatabaseHas('posts', [
            'title' => 'Test title',
        ]);
    }

    /** @test */
    public function author_can_create_post()
    {
        $author = User::factory()->create();
        $author->assignRole('author');
        
        $response = $this->actingAs($author)
            ->post(Route('posts.store'), $this->validData());
            
        $response->assertRedirect(route('posts.index'));
        
        $this->assertDatabaseCount('posts', 1);
    }

    /** @test */
    public function admin_can_create_post()
    {
        $admin = Admin::factory()->create();
        
        $response = $this->actingAs($admin, 'admin')
            ->post(Route('admin.posts.store'), $this->validData());
            
        $response->assertRedirect(Route('admin.posts.index'));
        
        $this->assertDatabaseCount('posts', 1);
    }

    /** @test */
    public function normal_user_cannot_create_post()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)
            ->post(route('posts.store'), $this->validData());

        $response->assertForbidden();
        $this->assertDatabaseCount('posts', 0);
    }

    /** @test */
    public function gust_cannot_create_post()
    {
        $response = $this->post(route('posts.store'), $this->validData());

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('posts', 0);
    }

    /** @test */
    public function validation_error_when_required_fields_missing()
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $response = $this->actingAs($editor)
            ->post(route('posts.store'), []);

        $response->assertSessionHasErrors(['title', 'content']);
        $this->assertDatabaseCount('posts', 0);
    }

    protected function validData(): array
    {
        return [
            'title'     => 'Test title',
            'content'   => 'Test content',
            'published' => true,
        ];
    }

}
