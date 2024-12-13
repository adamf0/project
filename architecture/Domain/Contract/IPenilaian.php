<?php
namespace Architecture\Domain\Contract;

use Architecture\Domain\Entity\BaseEntity;
use Architecture\Domain\Entity\Matriks;
use Architecture\Domain\Shared\NamingEntity;
use Illuminate\Support\Collection;

abstract class IPenilaian extends BaseEntity{
    public ?Matriks $matriks;
    public $nama_berkas;
    public $url;
    public $file;
    public $tahun=null;
    public Collection $berkas;

    public function GetMatriks()
    {
        return $this->matriks;
    }
    public function GetNamaBerkas()
    {
        return $this->nama_berkas;
    }
    public function GetUrl()
    {
        return $this->url;
    }
    public function GetFile()
    {
        return $this->file;
    }
    public function GetTahun()
    {
        return $this->tahun;
    }
    public function GetBerkas()
    {
        return $this->berkas;
    }
}