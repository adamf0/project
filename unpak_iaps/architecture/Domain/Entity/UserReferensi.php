<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Contract\IUser;

class UserReferensi extends IUser{
    public static function make($id=null){
        $instance = new self();
        $instance->id = $id;
        return $instance;
    }
}