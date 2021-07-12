<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Prize;

use App\Models\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrizeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_prizes()
    {
        $prizes = Prize::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('prizes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.prizes.index')
            ->assertViewHas('prizes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_prize()
    {
        $response = $this->get(route('prizes.create'));

        $response->assertOk()->assertViewIs('app.prizes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_prize()
    {
        $data = Prize::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('prizes.store'), $data);

        $this->assertDatabaseHas('prizes', $data);

        $prize = Prize::latest('id')->first();

        $response->assertRedirect(route('prizes.edit', $prize));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_prize()
    {
        $prize = Prize::factory()->create();

        $response = $this->get(route('prizes.show', $prize));

        $response
            ->assertOk()
            ->assertViewIs('app.prizes.show')
            ->assertViewHas('prize');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_prize()
    {
        $prize = Prize::factory()->create();

        $response = $this->get(route('prizes.edit', $prize));

        $response
            ->assertOk()
            ->assertViewIs('app.prizes.edit')
            ->assertViewHas('prize');
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

        $response = $this->put(route('prizes.update', $prize), $data);

        $data['id'] = $prize->id;

        $this->assertDatabaseHas('prizes', $data);

        $response->assertRedirect(route('prizes.edit', $prize));
    }

    /**
     * @test
     */
    public function it_deletes_the_prize()
    {
        $prize = Prize::factory()->create();

        $response = $this->delete(route('prizes.destroy', $prize));

        $response->assertRedirect(route('prizes.index'));

        $this->assertSoftDeleted($prize);
    }
}
