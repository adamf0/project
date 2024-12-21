<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Contract\IDokumenInduk;
use Illuminate\Support\Collection;

class DokumenIndukEntitas extends IDokumenInduk{
    public static function make($id=null, $nama_berkas=null, $url=null, $file=null, $tahun=null){
        $instance = new self();
        $instance->id = $id;
        $instance->nama_berkas = $nama_berkas;
        $instance->url = $url;
        $instance->file = $file;
        $instance->tahun = $tahun;
        return $instance;
    }
}