<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\University;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UniversityTest extends TestCase
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
    public function it_gets_universities_list(): void
    {
        $universities = University::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.universities.index'));

        $response->assertOk()->assertSee($universities[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_university(): void
    {
        $data = University::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.universities.store'), $data);

        $this->assertDatabaseHas('universities', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.universities.update', $university),
            $data
        );

        $data['id'] = $university->id;

        $this->assertDatabaseHas('universities', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_university(): void
    {
        $university = University::factory()->create();

        $response = $this->deleteJson(
            route('api.universities.destroy', $university)
        );

        $this->assertModelMissing($university);

        $response->assertNoContent();
    }
}
