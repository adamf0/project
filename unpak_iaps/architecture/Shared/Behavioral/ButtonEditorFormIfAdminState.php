<?php
namespace Architecture\Shared\Behavioral;

class ButtonEditorFormIfAdminState extends MappingHtmlOrmStateInterface{
    public function __construct(public $item, public $type){}
    
    public function handle() {
        $this->output .= '<a href="'.route('mod.index',['type'=>$this->type,'id'=>$this->item->GetId()]).'" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>';
        if($this->type=="hibahPKM"){
            $this->output .= '<a href="'.route('pkm.delete',['id'=>$this->item->GetId()]).'" class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></a>';
            $this->output .= '<a href="'.route('pkm.detail',['id'=>$this->item->GetId()]).'" class="btn btn-info"><i class="bi bi-eye"></i></a>';
        } else if($this->type=="hibahPKMNasional"){
            $this->output .= '<a href="'.route('pkmNasional.delete',['id'=>$this->item->GetId()]).'" class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></a>';
            $this->output .= '<a href="'.route('pkmNasional.detail',['id'=>$this->item->GetId()]).'" class="btn btn-info"><i class="bi bi-eye"></i></a>';
        } else if($this->type=="hibahNasional"){ //error ke internal
            $this->output .= '<a href="'.route('penelitianNasional.delete',['id'=>$this->item->GetId()]).'" class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></a>';
            $this->output .= '<a href="'.route('penelitianNasional.detail',['id'=>$this->item->GetId()]).'" class="btn btn-info"><i class="bi bi-eye"></i></a>';
        } else if($this->type=="hibahInternal"){
            $this->output .= '<a href="'.route('penelitianInternal.delete',['id'=>$this->item->GetId()]).'" class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></a>';
            $this->output .= '<a href="'.route('penelitianInternal.detail',['id'=>$this->item->GetId()]).'" class="btn btn-info"><i class="bi bi-eye"></i></a>';
        }

        return $this;
    }
}