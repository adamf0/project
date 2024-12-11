<?php

namespace Architecture\Application\Penilaian\Create;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\Penilaian as ModelPenilaian;

class CreatePenilaianCommandHandler extends CommandHandler
{
    public function handle(CreatePenilaianCommand $command)
    {
        $peniliaianBaru = new ModelPenilaian();
        $peniliaianBaru->id_matriks = $command->GetMatriks();
        $peniliaianBaru->nama_berkas = $command->GetNamaBerkas();
        $peniliaianBaru->url = $command->GetUrl();
        $peniliaianBaru->saveOrFail();
    }
}