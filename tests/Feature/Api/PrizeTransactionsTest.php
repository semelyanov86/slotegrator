<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Prize;
use App\Models\Transaction;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrizeTransactionsTest extends TestCase
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
    public function it_gets_prize_transactions()
    {
        $prize = Prize::factory()->create();
        $transactions = Transaction::factory()
            ->count(2)
            ->create([
                'prize_id' => $prize->id,
            ]);

        $response = $this->getJson(
            route('api.prizes.transactions.index', $prize)
        );

        $response->assertOk()->assertSee($transactions[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_prize_transactions()
    {
        $prize = Prize::factory()->create();
        $data = Transaction::factory()
            ->make([
                'prize_id' => $prize->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.prizes.transactions.store', $prize),
            $data
        );
        unset($data['product_id']);
        $this->assertDatabaseHas('transactions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $transaction = Transaction::latest('id')->first();

        $this->assertEquals($prize->id, $transaction->prize_id);
    }
}
