<?php
namespace Architecture\Shared\Behavioral;

use Architecture\Domain\Enum\TypeStatusPengajuan;

class ButtonFundingInternalState extends MappingHtmlOrmStateInterface{
    public function __construct(public $item, public $withFlex=false){}
    
    public function handle() {
        if($this->withFlex) $this->output .= "<div class='col mt-2'>";
        $this->output .= "
            <button type='button' class='btn btn-success btn-fund' data-action='".route('penelitianInternal.funding')."' data-id_penelitian_internal='".$this->item->GetId()."' data-type='".TypeStatusPengajuan::TERIMA_PENDANAAN->val()."'>
                <i class='bi bi-clipboard-check'></i>
            </button>
            ";
        if($this->withFlex) $this->output .= "</div>";

        if($this->withFlex) $this->output .= "<div class='col mt-2'>";
        $this->output .= "
            <button type='button' class='btn btn-warning btn-fund' data-action='".route('penelitianInternal.funding')."' data-id_penelitian_internal='".$this->item->GetId()."' data-type='".TypeStatusPengajuan::PERBAIKAN->val()."'>
                <i class='bi bi-clipboard-check'></i>
            </button>
            ";
        if($this->withFlex) $this->output .= "</div>";

        if($this->withFlex) $this->output .= "<div class='col mt-2'>";
        $this->output .= "
            <button type='button' class='btn btn-danger btn-fund' data-action='".route('penelitianInternal.funding')."' data-id_penelitian_internal='".$this->item->GetId()."' data-type='".TypeStatusPengajuan::TOLAK_PENDANAAN->val()."'>
                <i class='bi bi-clipboard-minus'></i>
            </button>
            ";
        if($this->withFlex) $this->output .= "</div>";

        return $this;
    }
}