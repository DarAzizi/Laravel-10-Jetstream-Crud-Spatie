<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\City;
use App\Models\Certificate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityCertificatesTest extends TestCase
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
    public function it_gets_city_certificates(): void
    {
        $city = City::factory()->create();
        $certificates = Certificate::factory()
            ->count(2)
            ->create([
                'city_id' => $city->id,
            ]);

        $response = $this->getJson(
            route('api.cities.certificates.index', $city)
        );

        $response->assertOk()->assertSee($certificates[0]->year);
    }

    /**
     * @test
     */
    public function it_stores_the_city_certificates(): void
    {
        $city = City::factory()->create();
        $data = Certificate::factory()
            ->make([
                'city_id' => $city->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.cities.certificates.store', $city),
            $data
        );

        $this->assertDatabaseHas('certificates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $certificate = Certificate::latest('id')->first();

        $this->assertEquals($city->id, $certificate->city_id);
    }
}
