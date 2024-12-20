<?php

namespace App\View\Components;

use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputText extends Component
{
    /**
     * Create a new component instance.
     */
    public $title=false;
    public $name;
    public $default=false;
    public $class='';
    public $disable = false;
    public $pref = '';
    public $suff = '';
    public $placeholder = '';
    public function __construct($title=false,$name,$default=false,$class='',$disable=false,$placeholder='',$pref='',$suff='')
    {
        // if($title==null) throw new Exception('title in component indicator cannot be null'); 
        if($name==null) throw new Exception('name in component indicator cannot be null'); 

        $this->title = $title;
        $this->name = $name;
        $this->default = $default;
        $this->class = $class;
        $this->disable = $disable;
        $this->pref = $pref;
        $this->suff = $suff;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-text',[
            'title'=>$this->title,
            'name'=>$this->name,
            'default'=>$this->default,
            'class'=>$this->class,
            'disable'=>$this->disable,
            'pref'=>$this->pref,
            'suff'=>$this->suff,
            'placeholder'=>$this->placeholder,
        ]);
    }
}
