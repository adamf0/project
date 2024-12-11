<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class CreateUserRuleReq{
    public static function create() { 
        return [
            "nama" => "required",
            "username" => "required",
            "password" => "required",
            "level" => "required",
            // "deskripsi" => "required",
        ]; 
    }
}