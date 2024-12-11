<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Contract\IMatriks;

class MatriksEntitas extends IMatriks{
    public static function make($id=null, $nama=null, $deskripsi=null){
        $instance = new self();
        $instance->id = $id;
        $instance->nama = $nama;
        $instance->deskripsi = $deskripsi;
        return $instance;
    }
}