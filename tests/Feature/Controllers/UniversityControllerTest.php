<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\University;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UniversityControllerTest extends TestCase
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
    public function it_displays_index_view_with_universities(): void
    {
        $universities = University::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('universities.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.universities.index')
            ->assertViewHas('universities');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_university(): void
    {
        $response = $this->get(route('universities.create'));

        $response->assertOk()->assertViewIs('app.universities.create');
    }

    /**
     * @test
     */
    public function it_stores_the_university(): void
    {
        $data = University::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('universities.store'), $data);

        $this->assertDatabaseHas('universities', $data);

        $university = University::latest('id')->first();

        $response->assertRedirect(route('universities.edit', $university));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_university(): void
    {
        $university = University::factory()->create();

        $response = $this->get(route('universities.show', $university));

        $response
            ->assertOk()
            ->assertViewIs('app.universities.show')
            ->assertViewHas('university');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_university(): void
    {
        $university = University::factory()->create();

        $response = $this->get(route('universities.edit', $university));

        $response
            ->assertOk()
            ->assertViewIs('app.universities.edit')
            ->assertViewHas('university');
    }

    /**
     * @test
     */
    public function it_updates_the_university(): void
    {
        $university = University::factory()->create();

        $data = [
            'name' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->put(
            route('universities.update', $university),
            $data
        );

        $data['id'] = $university->id;

        $this->assertDatabaseHas('universities', $data);

        $response->assertRedirect(route('universities.edit', $university));
    }

    /**
     * @test
     */
    public function it_deletes_the_university(): void
    {
        $university = University::factory()->create();

        $response = $this->delete(route('universities.destroy', $university));

        $response->assertRedirect(route('universities.index'));

        $this->assertModelMissing($university);
    }
}
