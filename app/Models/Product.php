<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'inventory'];

    protected $searchableFields = ['*'];

    public function prizes()
    {
        return $this->hasMany(Prize::class);
    }
}
