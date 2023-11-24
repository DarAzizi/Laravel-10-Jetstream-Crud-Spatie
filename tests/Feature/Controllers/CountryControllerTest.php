<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Country;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryControllerTest extends TestCase
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
    public function it_displays_index_view_with_countries(): void
    {
        $countries = Country::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('countries.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.countries.index')
            ->assertViewHas('countries');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_country(): void
    {
        $response = $this->get(route('countries.create'));

        $response->assertOk()->assertViewIs('app.countries.create');
    }

    /**
     * @test
     */
    public function it_stores_the_country(): void
    {
        $data = Country::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('countries.store'), $data);

        $this->assertDatabaseHas('countries', $data);

        $country = Country::latest('id')->first();

        $response->assertRedirect(route('countries.edit', $country));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_country(): void
    {
        $country = Country::factory()->create();

        $response = $this->get(route('countries.show', $country));

        $response
            ->assertOk()
            ->assertViewIs('app.countries.show')
            ->assertViewHas('country');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_country(): void
    {
        $country = Country::factory()->create();

        $response = $this->get(route('countries.edit', $country));

        $response
            ->assertOk()
            ->assertViewIs('app.countries.edit')
            ->assertViewHas('country');
    }

    /**
     * @test
     */
    public function it_updates_the_country(): void
    {
        $country = Country::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->put(route('countries.update', $country), $data);

        $data['id'] = $country->id;

        $this->assertDatabaseHas('countries', $data);

        $response->assertRedirect(route('countries.edit', $country));
    }

    /**
     * @test
     */
    public function it_deletes_the_country(): void
    {
        $country = Country::factory()->create();

        $response = $this->delete(route('countries.destroy', $country));

        $response->assertRedirect(route('countries.index'));

        $this->assertModelMissing($country);
    }
}
