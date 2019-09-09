<?php

namespace Tests\Feature;

use App\Users;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_users_can_be_listed()
    {
        $user = factory(Users::class)->create();
        $response = $this->actingAs($user)->get('/users');
        $response->assertStatus(200);
    }

    /** @test */
    public function as_create_user_get_page()
    {
        $user = factory(Users::class)->make();
        $response = $this->actingAs($user)->get('/users/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function an_user_can_be_created()
    {
        $user = factory(Users::class)->make();
        $data = array(
            'name' => $user['name'],
            'email' => $user['email'],
            'id_profile' => $user['id_profile'],
            'password' => $user['password'],
            'password_confirmation' => $user['password'],
            'active' => $user['active'],
            'blocked' => $user['blocked']
        );
        $response = $this->actingAs($user)->post('/users/create', $data);
        $response->assertRedirect(route('users.list'));
    }

    /** @test */
    public function as_edit_user_get_page()
    {
        $user = factory(Users::class)->create();
        $response = $this->actingAs($user)->get('/users/edit/' . base64_encode($user['id']));
        $response->assertStatus(200);
    }

    /** @test */
    public function an_user_can_be_updated()
    {
        $user = factory(Users::class)->create();
        $data = array(
            'name' => $user['name'],
            'email' => $user['email'],
            'id_profile' => $user['id_profile'],
            'password' => $user['password'],
            'password_confirmation' => $user['password'],
            'active' => $user['active'],
            'blocked' => $user['blocked']
        );
        $response = $this->actingAs($user)->post('/users/edit/' . base64_encode($user['id']), $data);
        $response->assertRedirect(route('users.list'));
    }

    /** @test */
    public function an_user_can_be_removed()
    {
        $user = factory(Users::class)->create();
        $response = $this->actingAs($user)->get('/users/remove/' . base64_encode($user['id']));
        $response->assertRedirect(route('users.list'));
    }
}
