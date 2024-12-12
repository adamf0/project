<?php
namespace Architecture\Shared\Behavioral;

use Architecture\Domain\Enum\TypeStatusPengajuan;

class EnableButtonEditorFormIfOwnData implements RuleRenderHtmlStartegy{
    public function __construct(public $item, public $level, public $nidn){} 
    public function rule(){
        $ruleStatusDosen = in_array($this->item->GetStatus(), [TypeStatusPengajuan::DEFAULT,TypeStatusPengajuan::PERBAIKAN,TypeStatusPengajuan::TOLAK,TypeStatusPengajuan::TOLAK_PENDANAAN,TypeStatusPengajuan::TOLAK_ANGGOTA]);
        return $this->level=="dosen" && $this->nidn==$this->item->GetDosen()->GetNidn() && $ruleStatusDosen;
    }
}