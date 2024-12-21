<?php

namespace Architecture\Application\DokumenInduk\Create;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\DokumenInduk as ModelDokumenInduk;

class CreateDokumenIndukCommandHandler extends CommandHandler
{
    public function handle(CreateDokumenIndukCommand $command)
    {
        $peniliaianBaru = new ModelDokumenInduk();
        $peniliaianBaru->nama_berkas = $command->GetNamaBerkas();
        $peniliaianBaru->url = $command->GetUrl();
        if(!empty($command->GetFile())){
            $peniliaianBaru->file = $command->GetFile();
        }
        $peniliaianBaru->tahun = $command->GetTahun();
        $peniliaianBaru->saveOrFail();
    }
}