<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Shared\NamingEntity;
use Illuminate\Support\Collection;

class Penilaian extends BaseEntity{
    public function __construct(public $id=null,public $matriks=null,public $nama_berkas=null,public $url=null,public $file=null,public $tahun=null,public Collection $berkas){}

    public function GetMatriks() {
        return $this->matriks;
    }
    public function GetNamaBerkas() {
        return $this->nama_berkas;
    }
    public function GetUrl() {
        return $this->url;
    }
    public function GetFile() {
        return $this->file;
    }
    public function GetTahun() {
        return $this->tahun;
    }
    public function GetBerkas() {
        return $this->berkas;
    }
}