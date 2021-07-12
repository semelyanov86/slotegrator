<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Prize;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductPrizesTest extends TestCase
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
    public function it_gets_product_prizes()
    {
        $product = Product::factory()->create();
        $prizes = Prize::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.prizes.index', $product)
        );

        $response->assertOk()->assertSee($prizes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_prizes()
    {
        $product = Product::factory()->create();
        $data = Prize::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.prizes.store', $product),
            $data
        );

        $this->assertDatabaseHas('prizes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $prize = Prize::latest('id')->first();

        $this->assertEquals($product->id, $prize->product_id);
    }
}
