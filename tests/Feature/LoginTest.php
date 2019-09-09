<?php

namespace Tests\Feature;

use App\Users;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /** @test */
    public function as_login_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function as_post_login_success()
    {
        $user = factory(Users::class)->make();
        $response = $this->actingAs($user)->post('/', array('email' => $user->email, 'password' => $user->password));
        $this->assertAuthenticatedAs($user);
    }

}
