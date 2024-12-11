<?php
namespace Architecture\Shared\Behavioral;

class FilterInternalForLppm implements FilterStartegy{
    public function __construct(public $filter=[],public $modder=0){}

    public function onFilter($row){
        return count($this->filter) && $this->modder==0? in_array($row->status, $this->filter): $row;
    }
}