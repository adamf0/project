<?php

namespace Architecture\Shared\Structural;

class TableColspan implements HtmlElement
{
    public function __construct(private int $lengthSpan, private string $content, public $style='padding: 1px 5px 5px 0px'){}

    public function render(): string
    {
        return "<td colspan={$this->lengthSpan}>{$this->content}</td>";
    }
}