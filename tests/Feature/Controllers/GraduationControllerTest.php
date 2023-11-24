<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Graduation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GraduationControllerTest extends TestCase
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
    public function it_displays_index_view_with_graduations(): void
    {
        $graduations = Graduation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('graduations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.graduations.index')
            ->assertViewHas('graduations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_graduation(): void
    {
        $response = $this->get(route('graduations.create'));

        $response->assertOk()->assertViewIs('app.graduations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_graduation(): void
    {
        $data = Graduation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('graduations.store'), $data);

        $this->assertDatabaseHas('graduations', $data);

        $graduation = Graduation::latest('id')->first();

        $response->assertRedirect(route('graduations.edit', $graduation));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_graduation(): void
    {
        $graduation = Graduation::factory()->create();

        $response = $this->get(route('graduations.show', $graduation));

        $response
            ->assertOk()
            ->assertViewIs('app.graduations.show')
            ->assertViewHas('graduation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_graduation(): void
    {
        $graduation = Graduation::factory()->create();

        $response = $this->get(route('graduations.edit', $graduation));

        $response
            ->assertOk()
            ->assertViewIs('app.graduations.edit')
            ->assertViewHas('graduation');
    }

    /**
     * @test
     */
    public function it_updates_the_graduation(): void
    {
        $graduation = Graduation::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->put(route('graduations.update', $graduation), $data);

        $data['id'] = $graduation->id;

        $this->assertDatabaseHas('graduations', $data);

        $response->assertRedirect(route('graduations.edit', $graduation));
    }

    /**
     * @test
     */
    public function it_deletes_the_graduation(): void
    {
        $graduation = Graduation::factory()->create();

        $response = $this->delete(route('graduations.destroy', $graduation));

        $response->assertRedirect(route('graduations.index'));

        $this->assertModelMissing($graduation);
    }
}
