<?php
namespace Architecture\Shared\Behavioral;

class ButtonEditorPkmNasionalOwnDataState extends MappingHtmlOrmStateInterface{
    public function __construct(public $item){}
    
    public function handle() {
        $this->output .= '<a href="'.route('pkmNasional.edit',['id'=>$this->item->GetId(),"type"=>"edit","step"=>"step1"]).'" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>';
        $this->output .= '<a href="'.route('pkmNasional.delete',['id'=>$this->item->GetId()]).'" class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></a>';
        
        return $this;
    }
}