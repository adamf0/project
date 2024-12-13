<?php

namespace Architecture\Domain\RuleValidationRequest\Rule;

class CreatePenilaianRuleReq {
    public static function create() { 
        return [
            "matriks" => "required|string",
            "nama_berkas" => "required|string",
            "url" => "required_without:file|nullable|string",
            "file" => "required_without:url|nullable|file|mimes:pdf|max:5120",
        ]; 
    }
}
