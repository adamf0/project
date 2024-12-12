<?php

namespace Architecture\Shared\Behavioral;

class Result1AdministationInternal extends MappingHtmlOrmStateInterface
{
    public function __construct(public $pointRevisi = [], public $level) {}

    public function handle()
    {
        $this->output .= match ($this->level) {
            "fakultas" => count($this->pointRevisi) ? "sudah ada administrasi tapi belum ada tindak lanjut" : "belum ada administrasi dari fakultas",
            "lppm" => count($this->pointRevisi) ? "sudah ada administrasi tapi belum ada tindak lanjut" : "belum ada administrasi dari LPPM",
            default => "belum ada administrasi dari N/A"
        };
        return $this;
    }
}
