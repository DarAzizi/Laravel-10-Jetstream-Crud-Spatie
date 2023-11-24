<?php

namespace Tests\Feature\Controllers;

use App\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_users(): void
    {
        $users = User::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('users.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.users.index')
            ->assertViewHas('users');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_user(): void
    {
        $response = $this->get(route('users.create'));

        $response->assertOk()->assertViewIs('app.users.create');
    }

    /**
     * @test
     */
    public function it_stores_the_user(): void
    {
        $data = User::factory()
            ->make()
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->post(route('users.store'), $data);

        unset($data['password']);
        unset($data['email_verified_at']);
        unset($data['two_factor_confirmed_at']);
        unset($data['current_team_id']);
        unset($data['profile_photo_path']);

        $this->assertDatabaseHas('users', $data);

        $user = User::latest('id')->first();

        $response->assertRedirect(route('users.edit', $user));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_user(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.show', $user));

        $response
            ->assertOk()
            ->assertViewIs('app.users.show')
            ->assertViewHas('user');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_user(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.edit', $user));

        $response
            ->assertOk()
            ->assertViewIs('app.users.edit')
            ->assertViewHas('user');
    }

    /**
     * @test
     */
    public function it_updates_the_user(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique->email(),
            'gender' => \Arr::random(['male', 'female', 'other']),
            'date_of_birth' => $this->faker->date(),
        ];

        $data['password'] = \Str::random('8');

        $response = $this->put(route('users.update', $user), $data);

        unset($data['password']);
        unset($data['email_verified_at']);
        unset($data['two_factor_confirmed_at']);
        unset($data['current_team_id']);
        unset($data['profile_photo_path']);

        $data['id'] = $user->id;

        $this->assertDatabaseHas('users', $data);

        $response->assertRedirect(route('users.edit', $user));
    }

    /**
     * @test
     */
    public function it_deletes_the_user(): void
    {
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertRedirect(route('users.index'));

        $this->assertModelMissing($user);
    }
}
