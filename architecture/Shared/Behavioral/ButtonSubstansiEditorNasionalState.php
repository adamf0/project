<?php
namespace Architecture\Shared\Behavioral;

class ButtonSubstansiEditorNasionalState extends MappingHtmlOrmStateInterface{
    public function __construct(public $item, public $type){}
    
    public function handle() {
        $this->output = '<a href="'.route('penelitianNasional.substansi',['type'=>$this->type,'id_penelitian_nasional'=>$this->item->GetId()]).'" class="btn btn-info"><i class="bi bi-file-earmark-text"></i></a>';

        return $this;
    }
}