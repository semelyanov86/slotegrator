<?php


namespace Tests\Feature;

use App\Models\Prize;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConvertMoneyToBonusTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testMoneyConvertedToBonus(): void
    {
        $this->actingAs(
            User::all()->first()
        );
        $prizeMoney = Prize::where('key', '=', 'MONEY')->get()->first();
        $prizeBonus = Prize::where('key', '=','Bonus')->get()->first();
        $transaction = Transaction::create([
            'value' => 12,
            'prize_id' => $prizeMoney->id,
            'user_id' => 1,
            'product_id' => null,
            'done_at' => null,
            'description' => 'You got a money'
        ]);
        $transaction->convertToBonus();
        $this->assertDatabaseHas('transactions', [
            'value' => 24,
        ]);
        $this->assertSoftDeleted('transactions', [
            'value' => 12
        ]);
    }
}
