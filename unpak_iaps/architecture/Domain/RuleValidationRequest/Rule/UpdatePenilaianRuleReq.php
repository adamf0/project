<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class UpdatePenilaianRuleReq{
    public static function create() { 
        return [
            "id" => "required",
            "matriks" => "required",
            "nama_berkas" => "required",
            "url" => "required",
        ]; 
    }
}