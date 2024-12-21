<?php
namespace Architecture\Domain\Contract;

use Architecture\Domain\Entity\BaseEntity;
use Illuminate\Support\Collection;

abstract class IDokumenInduk extends BaseEntity{
    public $nama_berkas;
    public $url;
    public $file;
    public $tahun=null;
    
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
}