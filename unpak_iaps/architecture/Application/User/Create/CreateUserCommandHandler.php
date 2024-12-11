<?php

namespace Architecture\Application\User\Create;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\User as ModelUser;
use Illuminate\Support\Facades\Hash;

class CreateUserCommandHandler extends CommandHandler
{
    public function handle(CreateUserCommand $command)
    {
        $UserBaru = new ModelUser();
        $UserBaru->name = $command->GetNama();
        $UserBaru->username = $command->GetUsername();
        $UserBaru->password = Hash::make($command->GetPassword());
        $UserBaru->plain_password = $command->GetPassword();
        $UserBaru->level = $command->GetLevel();
        $UserBaru->saveOrFail();
    }
}