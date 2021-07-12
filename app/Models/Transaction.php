<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'value',
        'description',
        'prize_id',
        'user_id',
        'done_at',
        'product_id'
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'done_at' => 'datetime',
    ];

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function convertToBonus(): Transaction
    {
        $prizeModel = Prize::where('key', '=', 'Bonus')->get()->first();
        $newValue = $this->value * config('services.prize.' . strtolower($this->prize->key) . '.conversion_rate');
        $transaction = self::create([
            'value' => $newValue,
            'prize_id' => $prizeModel->id,
            'user_id' => \Auth::id(),
            'product_id' => null,
            'done_at' => null,
            'description' => 'You got a super bonus - ' . $newValue . ' !'
        ]);
        $this->delete();
        return $transaction;
    }
}
