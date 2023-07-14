<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class Reservacion extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'reservacions';
}
