<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multipleuploads extends Model
{
    protected $table ='multipleuploads';
    protected $primaryKey = 'id';
    protected $fillable = array('filename','created_at','updated_at');
}
