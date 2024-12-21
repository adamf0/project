<?php
namespace Architecture\Domain\Entity;

class DokumenInduk extends BaseEntity{
    public function __construct(public $id=null,public $nama_berkas=null,public $url=null,public $file=null,public $tahun=null){}

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
}