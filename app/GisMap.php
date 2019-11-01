<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GisMap extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'Lintang',
        'Bujur',
        'Kedalaman',
        'Magnitude',
        'Audio_Link',
        'Video_Link',
    ];
}
