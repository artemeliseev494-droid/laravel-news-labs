<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Text;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_pages_are_accessible(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/category')->assertStatus(200);
    }

    public function test_user_can_register_with_login_and_password(): void
    {
        $response = $this->post('/register', [
            'login' => 'newuser777',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'login' => 'newuser777',
        ]);
    }

    public function test_user_can_login_with_login_and_password(): void
    {
        $response = $this->post('/login', [
            'login' => 'user',
            'password' => 'qwerty123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_eloquent_relationships(): void
    {
        $text = Text::first();
        $this->assertNotNull($text->category);
        $this->assertNotNull($text->author);
        $this->assertEquals($text->user_id, $text->author->id);

        $category = Category::first();
        $this->assertTrue($category->texts()->count() >= 0);
    }

    public function test_role_middleware_access(): void
    {
        $this->get('/journalist')->assertRedirect('/login');
        $this->get('/admin')->assertRedirect('/login');

        $user = User::where('login', 'user')->first();
        $this->actingAs($user)->get('/journalist')->assertStatus(403);
        $this->actingAs($user)->get('/admin')->assertStatus(403);

        $journalist = User::where('login', 'journalist')->first();
        $this->actingAs($journalist)->get('/journalist')->assertStatus(200);
        $this->actingAs($journalist)->get('/admin')->assertStatus(403);

        $admin = User::where('login', 'admin')->first();
        $this->actingAs($admin)->get('/journalist')->assertStatus(200);
        $this->actingAs($admin)->get('/admin')->assertStatus(200);
    }
}
