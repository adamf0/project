<?php
namespace Architecture\Shared\Behavioral;

class ButtonDetailState extends MappingHtmlOrmStateInterface{
    public function __construct(public $item, public $type){}
    
    public function handle() {
        if($this->type=="internal"){
            $this->output = '<a href="'.route('penelitianInternal.detail',['id'=>$this->item->GetId()]).'" class="btn btn-info"><i class="bi bi-eye"></i></a>';
        } else if($this->type=="pkm"){
            $this->output = '<a href="'.route('pkm.detail',['id'=>$this->item->GetId()]).'" class="btn btn-info"><i class="bi bi-eye"></i></a>';
        } else if($this->type=="pkmNasional"){
            $this->output = '<a href="'.route('pkmNasional.detail',['id'=>$this->item->GetId()]).'" class="btn btn-info"><i class="bi bi-eye"></i></a>';
        } else if($this->type=="nasional"){
            $this->output = '<a href="'.route('penelitianNasional.detail',['id'=>$this->item->GetId()]).'" class="btn btn-info"><i class="bi bi-eye"></i></a>';
        }

        return $this;
    }
}