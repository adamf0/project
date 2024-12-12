<?php
namespace Architecture\Shared\Behavioral;

class EnableButtonEditorFormIfAdmin implements RuleRenderHtmlStartegy{
    public function __construct(public $item, public $level, public $nidn, public $modder=0){} 
    public function rule(){
        return $this->level=="lppm" && $this->modder==1;
    }
}