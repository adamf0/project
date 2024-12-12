<?php
namespace Architecture\Shared\Behavioral;

use Architecture\Domain\Enum\TypeStatusPengajuan;

class FilterInternalByKodeFak implements FilterStartegy{
    public function __construct(public $param){}

    public function onFilter($row){
        return $row->Dosen?->kode_fak==$this->param && $row->status==TypeStatusPengajuan::MENUNGGU_REVIEW_FAKULTAS->val();
    }
}