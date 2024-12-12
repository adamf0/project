<?php

namespace Architecture\Shared\Structural;

class TableCell implements HtmlElement
{
    public function __construct(private string $content, public $style='style="padding: 1px 5px 5px 0px"'){}

    public function render(): string
    {
        return "<td {$this->style}>{$this->content}</td>";
    }
}