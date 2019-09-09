<?php

namespace Tests\Feature;

use App\Users;
use App\Groups;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_group_can_be_listed()
    {
        $user = factory(Users::class)->create();
        $response = $this->actingAs($user)->get('/groups');
        $response->assertStatus(200);
    }

    /** @test */
    public function as_create_group_get_page()
    {
        $user = factory(Users::class)->make();
        $response = $this->actingAs($user)->get('/groups/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_group_can_be_created()
    {
        $user = factory(Users::class)->make();
        $group = factory(Groups::class)->make(array('created_by' => $user->id));
        $data = array('name' => $group->name);
        $response = $this->actingAs($user)->post('/groups/create', $data);
        $response->assertRedirect(route('groups.list'));
    }

    /** @test */
    public function as_edit_group_get_page()
    {
        $user = factory(Users::class)->create();
        $group = factory(Groups::class)->create(array('created_by' => $user->id));
        $response = $this->actingAs($user)->get('/groups/edit/' . base64_encode($group['id']));
        $response->assertStatus(200);
    }

    /** @test */
    public function a_group_can_be_updated()
    {
        $user = factory(Users::class)->create();
        $group = factory(Groups::class)->create(array('created_by' => $user->id));
        $data = array('name' => $group->name);
        $response = $this->actingAs($user)->post('/groups/edit/' . base64_encode($group['id']), $data);
        $response->assertRedirect(route('groups.list'));
    }

    /** @test */
    public function an_group_can_be_removed()
    {
        $user = factory(Users::class)->create();
        $group = factory(Groups::class)->create(array('created_by' => $user->id));
        $response = $this->actingAs($user)->get('/groups/remove/' . base64_encode($group['id']));
        $response->assertRedirect(route('groups.list'));
    }
}
