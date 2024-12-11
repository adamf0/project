<?php

namespace Architecture\Application\Matriks\Create;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\Matriks as ModelMatriks;

class CreateMatriksCommandHandler extends CommandHandler
{
    public function handle(CreateMatriksCommand $command)
    {
        $matriksBaru = new ModelMatriks();
        $matriksBaru->nama = $command->GetNama();
        $matriksBaru->deskripsi = $command->GetDeskripsi();
        $matriksBaru->saveOrFail();
    }
}