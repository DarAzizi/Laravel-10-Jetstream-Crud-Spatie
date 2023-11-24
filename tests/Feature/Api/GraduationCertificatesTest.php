<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Graduation;
use App\Models\Certificate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GraduationCertificatesTest extends TestCase
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
    public function it_gets_graduation_certificates(): void
    {
        $graduation = Graduation::factory()->create();
        $certificates = Certificate::factory()
            ->count(2)
            ->create([
                'graduation_id' => $graduation->id,
            ]);

        $response = $this->getJson(
            route('api.graduations.certificates.index', $graduation)
        );

        $response->assertOk()->assertSee($certificates[0]->year);
    }

    /**
     * @test
     */
    public function it_stores_the_graduation_certificates(): void
    {
        $graduation = Graduation::factory()->create();
        $data = Certificate::factory()
            ->make([
                'graduation_id' => $graduation->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.graduations.certificates.store', $graduation),
            $data
        );

        $this->assertDatabaseHas('certificates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $certificate = Certificate::latest('id')->first();

        $this->assertEquals($graduation->id, $certificate->graduation_id);
    }
}
