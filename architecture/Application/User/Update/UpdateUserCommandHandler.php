<?php

namespace Architecture\Application\User\Update;

use Architecture\Application\Abstractions\Messaging\CommandHandler;
use Architecture\External\Persistance\ORM\User as ModelUser;
use Illuminate\Support\Facades\Hash;

class UpdateUserCommandHandler extends CommandHandler
{
    public function handle(UpdateUserCommand $command)
    {
        $User = ModelUser::findOrFail($command->GetId());
        $User->id = $command->GetId();
        $User->name = $command->GetNama();
        $User->username = $command->GetUsername();
        if($User->plain_password!=$command->GetPassword()){
            $User->password = Hash::make($command->GetPassword());
            $User->plain_password = $command->GetPassword();
        }
        if(!empty($command->GetLevel())){
            $User->level = $command->GetLevel();
        }
        
        if($User->isDirty()) $User->saveOrFail();
    }
}