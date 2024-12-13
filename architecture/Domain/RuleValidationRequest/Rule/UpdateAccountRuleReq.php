<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class UpdateAccountRuleReq{
    public static function create() { 
        return [
            "nama" => "required",
            "username" => "required",
            // "password" => "required",
        ]; 
    }
}