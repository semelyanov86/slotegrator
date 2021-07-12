<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Prize;

use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrizeTest extends TestCase
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
    public function it_gets_prizes_list()
    {
        $prizes = Prize::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.prizes.index'));

        $response->assertOk()->assertSee($prizes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_prize()
    {
        $data = Prize::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.prizes.store'), $data);

        $this->assertDatabaseHas('prizes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_prize()
    {
        $prize = Prize::factory()->create();

        $product = Product::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'class' => $this->faker->text(255),
            'inventory' => $this->faker->randomNumber(0),
            'key' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'product_id' => $product->id,
        ];

        $response = $this->putJson(route('api.prizes.update', $prize), $data);

        $data['id'] = $prize->id;

        $this->assertDatabaseHas('prizes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_prize()
    {
        $prize = Prize::factory()->create();

        $response = $this->deleteJson(route('api.prizes.destroy', $prize));

        $this->assertSoftDeleted($prize);

        $response->assertNoContent();
    }
}
