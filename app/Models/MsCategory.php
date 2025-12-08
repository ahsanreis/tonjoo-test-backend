<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsCategory extends Model
{
     protected $table = 'ms_categories';

     protected $fillable = [
          'name',
     ];
}
