<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class CreateDokumenIndukRuleReq {
    public static function create() { 
        return [
            "nama_berkas" => "required|string",
            "url" => "required_without:file|nullable|string",
            "file" => "required_without:url|nullable|file|mimes:pdf|max:5120",
        ]; 
    }
}
