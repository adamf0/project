<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class CreatePenilaianRuleReq{
    public static function create() { 
        return [
            "matriks" => "required",
            "nama_berkas" => "required",
            "url" => "required",
        ]; 
    }
}