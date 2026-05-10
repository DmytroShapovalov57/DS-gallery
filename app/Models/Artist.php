<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'DS_Artists';
    protected $primaryKey = 'artist_id';

    protected $fillable = ['name', 'year_born', 'year_death', 'bio', 'img_path'];

    public function products()
    {
        return $this->hasMany(Product::class, 'artist_id', 'artist_id');
    }
}
