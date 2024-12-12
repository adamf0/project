<?php

namespace Architecture\Application\User\Delete;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\User as ModelUser;

class DeleteUserCommandHandler extends CommandHandler
{
    public function handle(DeleteUserCommand $command)
    {
        $bidangFokusPenelitian = ModelUser::findOrFail($command->GetId());
        $bidangFokusPenelitian->delete();
    }
}