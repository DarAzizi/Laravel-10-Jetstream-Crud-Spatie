<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Certificate;

use App\Models\City;
use App\Models\Result;
use App\Models\Remark;
use App\Models\Country;
use App\Models\University;
use App\Models\Graduation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CertificateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_certificates_list(): void
    {
        $certificates = Certificate::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.certificates.index'));

        $response->assertOk()->assertSee($certificates[0]->year);
    }

    /**
     * @test
     */
    public function it_stores_the_certificate(): void
    {
        $data = Certificate::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.certificates.store'), $data);

        $this->assertDatabaseHas('certificates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.certificates.update', $certificate),
            $data
        );

        $data['id'] = $certificate->id;

        $this->assertDatabaseHas('certificates', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_certificate(): void
    {
        $certificate = Certificate::factory()->create();

        $response = $this->deleteJson(
            route('api.certificates.destroy', $certificate)
        );

        $this->assertModelMissing($certificate);

        $response->assertNoContent();
    }
}
