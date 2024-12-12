<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class UpdateMatriksRuleReq{
    public static function create() { 
        return [
            "id" => "required",
            "nama" => "required",
            // "deskripsi" => "required",
        ]; 
    }
}