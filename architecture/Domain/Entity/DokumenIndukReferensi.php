<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Contract\IDokumenInduk;

class DokumenIndukReferensi extends IDokumenInduk{
    public static function make($id=null){
        $instance = new self();
        $instance->id = $id;
        return $instance;
    }
}