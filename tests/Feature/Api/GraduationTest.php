<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Graduation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GraduationTest extends TestCase
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
    public function it_gets_graduations_list(): void
    {
        $graduations = Graduation::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.graduations.index'));

        $response->assertOk()->assertSee($graduations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_graduation(): void
    {
        $data = Graduation::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.graduations.store'), $data);

        $this->assertDatabaseHas('graduations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.graduations.update', $graduation),
            $data
        );

        $data['id'] = $graduation->id;

        $this->assertDatabaseHas('graduations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_graduation(): void
    {
        $graduation = Graduation::factory()->create();

        $response = $this->deleteJson(
            route('api.graduations.destroy', $graduation)
        );

        $this->assertModelMissing($graduation);

        $response->assertNoContent();
    }
}
