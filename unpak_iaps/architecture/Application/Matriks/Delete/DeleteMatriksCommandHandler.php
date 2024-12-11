<?php

namespace Architecture\Application\Matriks\Delete;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\Matriks as ModelMatriks;

class DeleteMatriksCommandHandler extends CommandHandler
{
    public function handle(DeleteMatriksCommand $command)
    {
        $bidangFokusPenelitian = ModelMatriks::findOrFail($command->GetId());
        $bidangFokusPenelitian->delete();
    }
}