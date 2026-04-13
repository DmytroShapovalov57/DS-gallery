<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    protected $primaryKey = 'artwork_id';

    protected $fillable = [
        'title',
        'artist_id',
        'year',
        'genre',
        'price',
        'description',
        'image'
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id', 'artist_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'artwork_id', 'artwork_id');
    }

    public function savedItems()
    {
        return $this->hasMany(SaveItem::class, 'artwork_id', 'artwork_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'artwork_id', 'artwork_id');
    }
}
