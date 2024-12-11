<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Contract\IMatriks;

class MatriksReferensi extends IMatriks{
    public static function make($id=null){
        $instance = new self();
        $instance->id = $id;
        return $instance;
    }
}