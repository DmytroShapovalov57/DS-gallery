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
