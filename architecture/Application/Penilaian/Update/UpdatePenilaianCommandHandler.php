<?php

namespace Architecture\Application\Penilaian\Update;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\Application\Penilaian\Update\UpdatePenilaianCommand;
use Architecture\External\Persistance\ORM\Penilaian as ModelPenilaian;

class UpdatePenilaianCommandHandler extends CommandHandler
{
    public function handle(UpdatePenilaianCommand $command)
    {
        $Penilaian = ModelPenilaian::findOrFail($command->GetId());
        $Penilaian->id = $command->GetId();
        $Penilaian->id_matriks = $command->GetMatriks();
        $Penilaian->nama_berkas = $command->GetNamaBerkas();
        $Penilaian->url = $command->GetUrl();
        $Penilaian->tahun = $command->GetTahun();
        if($Penilaian->isDirty()) $Penilaian->saveOrFail();
    }
}