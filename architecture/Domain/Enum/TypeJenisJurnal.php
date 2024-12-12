<?php

namespace Architecture\Domain\Enum;

enum TypeJenisJurnal
{
    case Internal;
    case External;
    case Default;

    public static function parse($value)
    {
        if(is_null($value)) return self::Default;

        return match ((int) $value) {
            0 => self::Internal,
            1 => self::External
        };
    }
    public function val()
    {
        return match ($this) {
            self::Internal      => "0",
            self::External      => "1",
            default             => null,
        };
    }
    public function toString()
    {
        return match ($this) {
            self::Internal      => "Internal",
            self::External      => "External",
            default             => null,
        };
    }
}
