<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Myvalue extends Model
{
    use HasFactory;

    protected $fillable = [ 'value' ];

    protected $hidden = [ 'pivot' ];

    protected $dateFormat = 'U';

    public function mykey()
    {
        return $this->belongsToMany( Mykey::class )->using(MykeyMyvalue::class)->withTimestamps();;
    }
}
