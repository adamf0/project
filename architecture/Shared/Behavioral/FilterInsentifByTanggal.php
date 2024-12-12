<?php
namespace Architecture\Shared\Behavioral;

use Architecture\Domain\Enum\TypeStatusPengajuan;

class FilterInsentifByTanggal implements FilterStartegy{
    public function __construct(public $param){}

    public function onFilter($row){
        $tahun1 = date("Y", strtotime($row->tanggal_terbit));
        $tahun2 = $this->param;
        return $tahun1==$tahun2;
    }
}