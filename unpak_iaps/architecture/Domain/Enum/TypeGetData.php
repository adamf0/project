<?php

namespace Architecture\Domain\Enum;

enum TypeGetData
{
    case All;

    public function val()
    {
        return match ($this) {
            self::All => null,
            default   => null,
        };
    }
}
