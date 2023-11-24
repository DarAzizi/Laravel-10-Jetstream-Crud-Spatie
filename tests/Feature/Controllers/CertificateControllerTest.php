<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Certificate;

use App\Models\City;
use App\Models\Result;
use App\Models\Remark;
use App\Models\Country;
use App\Models\University;
use App\Models\Graduation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CertificateControllerTest extends TestCase
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
    public function it_displays_index_view_with_certificates(): void
    {
        $certificates = Certificate::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('certificates.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.certificates.index')
            ->assertViewHas('certificates');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_certificate(): void
    {
        $response = $this->get(route('certificates.create'));

        $response->assertOk()->assertViewIs('app.certificates.create');
    }

    /**
     * @test
     */
    public function it_stores_the_certificate(): void
    {
        $data = Certificate::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('certificates.store'), $data);

        $this->assertDatabaseHas('certificates', $data);

        $certificate = Certificate::latest('id')->first();

        $response->assertRedirect(route('certificates.edit', $certificate));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_certificate(): void
    {
        $certificate = Certificate::factory()->create();

        $response = $this->get(route('certificates.show', $certificate));

        $response
            ->assertOk()
            ->assertViewIs('app.certificates.show')
            ->assertViewHas('certificate');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_certificate(): void
    {
        $certificate = Certificate::factory()->create();

        $response = $this->get(route('certificates.edit', $certificate));

        $response
            ->assertOk()
            ->assertViewIs('app.certificates.edit')
            ->assertViewHas('certificate');
    }

    /**
     * @test
     */
    public function it_updates_the_certificate(): void
    {
        $certificate = Certificate::factory()->create();

        $user = User::factory()->create();
        $university = University::factory()->create();
        $country = Country::factory()->create();
        $city = City::factory()->create();
        $graduation = Graduation::factory()->create();
        $result = Result::factory()->create();
        $remark = Remark::factory()->create();

        $data = [
            'year' => $this->faker->date(),
            'user_id' => $user->id,
            'university_id' => $university->id,
            'country_id' => $country->id,
            'city_id' => $city->id,
            'graduation_id' => $graduation->id,
            'result_id' => $result->id,
            'remark_id' => $remark->id,
        ];

        $response = $this->put(
            route('certificates.update', $certificate),
            $data
        );

        $data['id'] = $certificate->id;

        $this->assertDatabaseHas('certificates', $data);

        $response->assertRedirect(route('certificates.edit', $certificate));
    }

    /**
     * @test
     */
    public function it_deletes_the_certificate(): void
    {
        $certificate = Certificate::factory()->create();

        $response = $this->delete(route('certificates.destroy', $certificate));

        $response->assertRedirect(route('certificates.index'));

        $this->assertModelMissing($certificate);
    }
}
