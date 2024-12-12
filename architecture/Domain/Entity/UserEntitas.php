<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Contract\IUser;

class UserEntitas extends IUser{
    public static function make($id=null,$nama=null,$username,$password=null,$plain_password=null,$level){
        $instance = new self();
        $instance->id = $id;
        $instance->nama = $nama;
        $instance->username = $username;
        $instance->password = $password;
        $instance->plain_password = $plain_password;
        $instance->level = $level;
        return $instance;
    }
}