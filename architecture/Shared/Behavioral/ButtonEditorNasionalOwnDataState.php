<?php
namespace Architecture\Shared\Behavioral;

class ButtonEditorNasionalOwnDataState extends MappingHtmlOrmStateInterface{
    public function __construct(public $item){}
    
    public function handle() {
        $this->output .= '<a href="'.route('penelitianNasional.edit',['id'=>$this->item->GetId(),"type"=>"edit","step"=>"step1"]).'" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>';
        $this->output .= '<a href="'.route('penelitianNasional.delete',['id'=>$this->item->GetId()]).'" class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></a>';
        
        return $this;
    }
}