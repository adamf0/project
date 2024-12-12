<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Shared\NamingEntity;

class Matriks extends BaseEntity{
    use NamingEntity;
    public function __construct(public $id=null,public $nama=null,public $deskripsi){}

    public function GetDeskripsi() {
        return $this->deskripsi;
    }
}