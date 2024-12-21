<?php

namespace Architecture\Application\DokumenInduk\Delete;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\DokumenInduk as ModelDokumenInduk;

class DeleteDokumenIndukCommandHandler extends CommandHandler
{
    public function handle(DeleteDokumenIndukCommand $command)
    {
        $penilaian = ModelDokumenInduk::findOrFail($command->GetId());
        $penilaian->delete();
    }
}