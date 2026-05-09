<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaveItem extends Model
{
    protected $table = 'DS_SaveItems';
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
