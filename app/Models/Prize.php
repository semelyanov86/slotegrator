<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prize extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'class',
        'inventory',
        'key',
        'description',
    ];

    protected $searchableFields = ['*'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
