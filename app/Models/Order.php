<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'confirmed',
        'delivered',
        'client_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, OrderDetail::class);
    }

    public function getProducts(): HasMany
    {
        return $this->hasMany(OrderDetail::class)
                    ->join('products', function($join)
                    {
                        $join->on('products.id','=','order_details.product_id');
                    });
    }
}
