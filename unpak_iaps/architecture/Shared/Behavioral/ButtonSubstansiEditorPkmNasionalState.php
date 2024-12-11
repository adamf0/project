<?php
namespace Architecture\Shared\Behavioral;

class ButtonSubstansiEditorPkmNasionalState extends MappingHtmlOrmStateInterface{
    public function __construct(public $item, public $type){}
    
    public function handle() {
        $this->output = '<a href="'.route('pkmNasional.substansi',['type'=>$this->type,'id_pkm'=>$this->item->GetId()]).'" class="btn btn-info">Substansi</a>';

        return $this;
    }
}