<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\University;
use App\Models\Certificate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UniversityCertificatesTest extends TestCase
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
    public function it_gets_university_certificates(): void
    {
        $university = University::factory()->create();
        $certificates = Certificate::factory()
            ->count(2)
            ->create([
                'university_id' => $university->id,
            ]);

        $response = $this->getJson(
            route('api.universities.certificates.index', $university)
        );

        $response->assertOk()->assertSee($certificates[0]->year);
    }

    /**
     * @test
     */
    public function it_stores_the_university_certificates(): void
    {
        $university = University::factory()->create();
        $data = Certificate::factory()
            ->make([
                'university_id' => $university->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.universities.certificates.store', $university),
            $data
        );

        $this->assertDatabaseHas('certificates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $certificate = Certificate::latest('id')->first();

        $this->assertEquals($university->id, $certificate->university_id);
    }
}
