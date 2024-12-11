<?php
namespace Architecture\Domain\Contract;

use Architecture\Domain\Entity\BaseEntity;
use Architecture\Domain\Shared\NamingEntity;

abstract class IMatriks extends BaseEntity{
    use NamingEntity;
    public $deskripsi;

    public function GetDeskripsi()
    {
        return $this->deskripsi;
    }
}