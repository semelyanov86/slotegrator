<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\PhysikBonusMail;
use App\Models\Prize;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;

final class PhyzicPrize extends PrizeAbstract implements PrizeInterface
{

    public function createTransaction(Prize $prize): Transaction
    {
        if (!$this->isBalanceEnough()) {
            throw new \DomainException('Balance not enough');
        }

        $value = $this->getRandomValue($prize);
        $product = $this->getRandomProduct();
        if (!$product) {
            throw new \DomainException('Balance with products not enough');
        }

        $transaction = Transaction::create([
            'value' => $value,
            'prize_id' => $prize->id,
            'user_id' => \Auth::id(),
            'product_id' => $product->id,
            'done_at' => null,
            'description' => 'You got a phyzik prize - ' . $product->name . '!'
        ]);

        $this->substractProduct($product, $value);

        return $transaction;
    }

    public function isBalanceEnough(): bool
    {
        /** @var Prize $prizeModel */
        $prizeModel = $this->getPrizeFromKey('Physic');
        if (!$prizeModel) {
            return false;
        }
        if ($prizeModel->inventory > 0) {
            return true;
        }
        return false;
    }

    public function acceptTransaction(Transaction $transaction): bool
    {
        $transaction->done_at = now();
        $transaction->save();
        Mail::to(config('services.prize.phyzik.operator'))->send(new PhysikBonusMail());
        return true;
    }

    protected function getRandomValue(Prize $prize): int
    {
        /** @var int $min */
        $min = config('services.prize.phyzik.min');
        /** @var int $max */
        $max = config('services.prize.phyzik.max');
        if ($max > $prize->inventory) {
            $max = $prize->inventory;
        }
        return random_int($min, $max);
    }

    protected function getRandomProduct(): ?Product
    {
        $products = Product::where('inventory', '>', 0)->get();
        if ($products->isEmpty()) {
            return null;
        }
        return $products->random();
    }

    private function substractProduct(Product $product, int $value): void
    {
        $this->substractFromInventory('Physic', $value);
        $product->inventory -= $value;
        $product->save();
    }

}
