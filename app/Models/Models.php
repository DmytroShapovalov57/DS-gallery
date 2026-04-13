<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $primaryKey = 'artist_id';

    protected $fillable = ['name', 'year', 'description', 'img_path'];

    public function artworks()
    {
        return $this->hasMany(Artwork::class, 'artist_id', 'artist_id');
    }
}

class Artwork extends Model
{
    protected $primaryKey = 'artwork_id';

    protected $fillable = ['name', 'artist_id', 'year', 'genre', 'price', 'description', 'img_path'];

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

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = ['user_id', 'price', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}

class OrderItem extends Model
{
    protected $primaryKey = 'order_item_id';

    protected $fillable = ['order_id', 'artwork_id', 'quantity'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id', 'artwork_id');
    }
}

class CartItem extends Model
{
    protected $primaryKey = 'cart_id';

    protected $fillable = ['user_id', 'artwork_id', 'quantity'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id', 'artwork_id');
    }
}

class SaveItem extends Model
{
    protected $primaryKey = 'save_id';

    protected $fillable = ['user_id', 'artwork_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id', 'artwork_id');
    }
}
