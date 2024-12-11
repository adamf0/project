<?php

namespace Architecture\Application\Penilaian\Delete;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\Penilaian as ModelPenilaian;

class DeletePenilaianCommandHandler extends CommandHandler
{
    public function handle(DeletePenilaianCommand $command)
    {
        $penilaian = ModelPenilaian::findOrFail($command->GetId());
        $penilaian->delete();
    }
}