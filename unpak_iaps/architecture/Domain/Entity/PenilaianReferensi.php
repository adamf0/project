<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Contract\IPenilaian;

class PenilaianReferensi extends IPenilaian{
    public static function make($id=null){
        $instance = new self();
        $instance->id = $id;
        return $instance;
    }
}