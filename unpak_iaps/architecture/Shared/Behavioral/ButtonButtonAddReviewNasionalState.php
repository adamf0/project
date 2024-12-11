<?php
namespace Architecture\Shared\Behavioral;

class ButtonButtonAddReviewNasionalState extends MappingHtmlOrmStateInterface{
    public function __construct(public $item,public $dataKey){}
    
    public function handle() {
        $listBlock = [];
        if(!empty($this->item?->GetDosen()?->GetNIDN())){
            $listBlock[] = $this->item?->GetDosen()?->GetNIDN();
        }
        $listAnggota = $this->item?->GetListAnggota()??collect([]);
        foreach($listAnggota as $anggota){
            if(!empty($anggota?->GetNIDN())){
                $listBlock[] = $anggota?->GetNIDN();
            }   
        }

        $this->output = '<a href="#" '.$this->dataKey.'="'.$this->item->GetId().'" data-block="'.implode(",",$listBlock).'" class="btn btn-info btn-add-reviewer"><i class="bi bi-person-add"></i></a>';

        return $this;
    }
}