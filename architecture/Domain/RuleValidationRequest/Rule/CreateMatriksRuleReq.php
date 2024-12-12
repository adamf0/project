<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class CreateMatriksRuleReq{
    public static function create() { 
        return [
            "nama" => "required",
            // "deskripsi" => "required",
        ]; 
    }
}