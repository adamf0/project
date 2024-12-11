<?php

namespace Architecture\External\Persistance\ORM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penilaian extends Model
{
   use HasFactory;
   protected $table = 'penilaian';
   protected $fillable = ['*'];

   public function Matriks():HasOne{
      return $this->hasOne(Matriks::class, "id","id_matriks");
   }
}
