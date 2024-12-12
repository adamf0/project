<?php

namespace Architecture\Application\Matriks\Update;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\Matriks as ModelMatriks;

class UpdateMatriksCommandHandler extends CommandHandler
{
    public function handle(UpdateMatriksCommand $command)
    {
        $matriks = ModelMatriks::findOrFail($command->GetId());
        $matriks->id = $command->GetId();
        $matriks->nama = $command->GetNama();
        $matriks->deskripsi = $command->GetDeskripsi();
        if($matriks->isDirty()) $matriks->saveOrFail();
    }
}