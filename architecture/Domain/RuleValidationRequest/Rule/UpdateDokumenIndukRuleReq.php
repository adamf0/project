<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class UpdateDokumenIndukRuleReq{
    public static function create() { 
        return [
            "id" => "required",
            "nama_berkas" => "required|string",
            // "url" => "required_without:file|nullable|string",
            // "file" => "required_without:url|nullable|file|mimes:pdf|max:5120",
        ]; 
    }
}