<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class UpdateUserRuleReq{
    public static function create() { 
        return [
            "id" => "required",
            "nama" => "required",
            "username" => "required",
            // "password" => "required",
            "level" => "required",
            // "deskripsi" => "required",
        ]; 
    }
}