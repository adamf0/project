<?php
namespace Architecture\Domain\Entity;

use Architecture\Domain\Contract\IPenilaian;
use Illuminate\Support\Collection;

class PenilaianEntitas extends IPenilaian{
    public static function make($id=null, ?Matriks $matriks=null, $nama_berkas=null, $url=null, $file=null, $tahun=null, Collection $berkas){
        $instance = new self();
        $instance->id = $id;
        $instance->matriks = $matriks;
        $instance->nama_berkas = $nama_berkas;
        $instance->url = $url;
        $instance->file = $file;
        $instance->tahun = $tahun;
        $instance->berkas = $berkas;
        return $instance;
    }
}