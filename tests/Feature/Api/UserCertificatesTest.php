<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Certificate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCertificatesTest extends TestCase
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
    public function it_gets_user_certificates(): void
    {
        $user = User::factory()->create();
        $certificates = Certificate::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.certificates.index', $user)
        );

        $response->assertOk()->assertSee($certificates[0]->year);
    }

    /**
     * @test
     */
    public function it_stores_the_user_certificates(): void
    {
        $user = User::factory()->create();
        $data = Certificate::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.certificates.store', $user),
            $data
        );

        $this->assertDatabaseHas('certificates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $certificate = Certificate::latest('id')->first();

        $this->assertEquals($user->id, $certificate->user_id);
    }
}
