<?php

namespace Architecture\External\Persistance\ORM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DokumenInduk extends Model
{
   use HasFactory;
   protected $table = 'dokumen_induk';
   protected $fillable = ['*'];
}
