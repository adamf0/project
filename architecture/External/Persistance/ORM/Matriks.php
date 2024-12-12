<?php

namespace Architecture\External\Persistance\ORM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matriks extends Model
{
   use HasFactory;
   protected $table = 'matriks';
   protected $fillable = ['*'];
}
