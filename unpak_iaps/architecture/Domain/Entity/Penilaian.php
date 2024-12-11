<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Shared\NamingEntity;
use Illuminate\Support\Collection;

class Penilaian extends BaseEntity{
    public function __construct(public $id=null,public $matriks=null,public $nama_berkas=null,public $url=null,public Collection $berkas){}

    public function GetMatriks() {
        return $this->matriks;
    }
    public function GetNamaBerkas() {
        return $this->nama_berkas;
    }
    public function GetUrl() {
        return $this->url;
    }
    public function GetBerkas() {
        return $this->berkas;
    }
}