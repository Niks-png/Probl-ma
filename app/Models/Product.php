<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'original_price',
        'current_price',
        'store',
        'store_class',
    ];


    public function getDisplayPriceAttribute(): string
    {
        return $this->current_price . '€';
    }


    public function getDisplayOriginalPriceAttribute(): ?string
    {
        return $this->original_price !== 'N/A' ? $this->original_price . '€' : null;
    }


    public function getTruncatedTitle(int $length = 60): string
    {
        return str($this->title)->limit($length)->value();
    }
}
