<?php

namespace Architecture\Shared\Structural;

class HtmlComposite implements HtmlElement
{
    private array $children = [];

    public function add(HtmlElement $element)
    {
        $this->children[] = $element;
        return $this;
    }

    public function render(): string
    {
        $output = '';
        foreach ($this->children as $child) {
            $output .= $child->render();
        }

        return $output;
    }
}