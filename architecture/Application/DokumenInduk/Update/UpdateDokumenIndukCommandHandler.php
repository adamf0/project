<?php

namespace Architecture\Application\DokumenInduk\Update;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\Application\DokumenInduk\Update\UpdateDokumenIndukCommand;
use Architecture\External\Persistance\ORM\DokumenInduk as ModelDokumenInduk;

class UpdateDokumenIndukCommandHandler extends CommandHandler
{
    public function handle(UpdateDokumenIndukCommand $command)
    {
        $DokumenInduk = ModelDokumenInduk::findOrFail($command->GetId());
        $DokumenInduk->id = $command->GetId();
        $DokumenInduk->nama_berkas = $command->GetNamaBerkas();
        $DokumenInduk->url = $command->GetUrl();
        if(!empty($command->GetFile())){
            $DokumenInduk->file = $command->GetFile();
        }
        $DokumenInduk->tahun = $command->GetTahun();
        if($DokumenInduk->isDirty()) $DokumenInduk->saveOrFail();
    }
}