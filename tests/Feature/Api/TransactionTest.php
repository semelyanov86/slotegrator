<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Transaction;

use App\Models\Prize;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
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
    public function it_gets_transactions_list()
    {
        $transactions = Transaction::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.transactions.index'));

        $response->assertOk()->assertSee($transactions[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_transaction()
    {
        $data = Transaction::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.transactions.store'), $data);

        $this->assertDatabaseHas('transactions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_transaction()
    {
        $transaction = Transaction::factory()->create();

        $prize = Prize::factory()->create();
        $user = User::factory()->create();

        $data = [
            'value' => $this->faker->randomNumber(0),
            'description' => $this->faker->sentence(15),
            'done_at' => $this->faker->dateTime,
            'prize_id' => $prize->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.transactions.update', $transaction),
            $data
        );

        $data['id'] = $transaction->id;

        $this->assertDatabaseHas('transactions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_transaction()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->deleteJson(
            route('api.transactions.destroy', $transaction)
        );

        $this->assertSoftDeleted($transaction);

        $response->assertNoContent();
    }
}
