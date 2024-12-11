<?php

namespace Architecture\Shared\Structural;

class TableRow extends HtmlComposite
{
    public function render(): string
    {
        return "<tr>" . parent::render() . "</tr>";
    }
}