<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Book;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
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
    public function it_gets_books_list(): void
    {
        $books = Book::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.books.index'));

        $response->assertOk()->assertSee($books[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_book(): void
    {
        $data = Book::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.books.store'), $data);

        $this->assertDatabaseHas('books', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_book(): void
    {
        $book = Book::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(route('api.books.update', $book), $data);

        $data['id'] = $book->id;

        $this->assertDatabaseHas('books', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson(route('api.books.destroy', $book));

        $this->assertModelMissing($book);

        $response->assertNoContent();
    }
}
