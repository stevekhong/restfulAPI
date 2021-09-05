<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mykey extends Model
{
    use HasFactory;

    protected $fillable = [ 'key' ];

    protected $hidden = [ 'pivot' ];

    protected $dateFormat = 'U';

    public function myvalue()
    {
        return $this->belongsToMany( Myvalue::class )->using(MykeyMyvalue::class)->withTimestamps();
    }

    /*
     * scope
     */

    public function scopeSearchByKey( $query, $key ) {
        return $query->where('key', '=', $key);
    }
}
