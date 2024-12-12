<?php

namespace Architecture\Shared\Structural;

class Table extends HtmlComposite
{
    public function __construct(public $style=''){}

    public function render(): string
    {
        return "<table class='{$this->style}'>" . parent::render() . "</table>";
    }
}