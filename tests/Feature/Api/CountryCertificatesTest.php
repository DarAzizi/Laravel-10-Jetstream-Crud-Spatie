<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Country;
use App\Models\Certificate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryCertificatesTest extends TestCase
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
    public function it_gets_country_certificates(): void
    {
        $country = Country::factory()->create();
        $certificates = Certificate::factory()
            ->count(2)
            ->create([
                'country_id' => $country->id,
            ]);

        $response = $this->getJson(
            route('api.countries.certificates.index', $country)
        );

        $response->assertOk()->assertSee($certificates[0]->year);
    }

    /**
     * @test
     */
    public function it_stores_the_country_certificates(): void
    {
        $country = Country::factory()->create();
        $data = Certificate::factory()
            ->make([
                'country_id' => $country->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.countries.certificates.store', $country),
            $data
        );

        $this->assertDatabaseHas('certificates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $certificate = Certificate::latest('id')->first();

        $this->assertEquals($country->id, $certificate->country_id);
    }
}
