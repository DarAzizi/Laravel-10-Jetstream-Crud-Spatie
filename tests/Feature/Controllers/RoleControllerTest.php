<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create(['email' => 'admin@admin.com']));
        
        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_roles(): void
    {
        $response = $this->get(route('roles.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.roles.index')
            ->assertViewHas('roles');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_role(): void
    {
        $response = $this->get(route('roles.create'));

        $response->assertOk()->assertViewIs('app.roles.create');
    }

    /**
     * @test
     */
    public function it_stores_the_role(): void
    {
        $response = $this->post(route('roles.store'), [
            'name' => 'secretary',
            'permissions' => []
        ]);

        $this->assertDatabaseHas('roles', ['name' => 'secretary']);

        $role = Role::latest('id')->first();

        $response->assertRedirect(route('roles.edit', $role));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_role(): void
    {
        $role = Role::first();

        $response = $this->get(route('roles.show', $role));

        $response
            ->assertOk()
            ->assertViewIs('app.roles.show')
            ->assertViewHas('role');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_role(): void
    {
        $role = Role::first();

        $response = $this->get(route('roles.edit', $role));

        $response
            ->assertOk()
            ->assertViewIs('app.roles.edit')
            ->assertViewHas('role');
    }

    /**
     * @test
     */
    public function it_updates_the_role(): void
    {
        $role = Role::first();

        $data = [
            'name' => 'manager',
            'permissions' => [],
        ];

        $response = $this->put(route('roles.update', $role), $data);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'manager'
        ]);

        $response->assertRedirect(route('roles.edit', $role));
    }

    /**
     * @test
     */
    public function it_deletes_the_role(): void
    {
        $role = Role::first();

        $response = $this->delete(route('roles.destroy', $role));

        $response->assertRedirect(route('roles.index'));
        
        $this->assertModelMissing($role);
    }
}
