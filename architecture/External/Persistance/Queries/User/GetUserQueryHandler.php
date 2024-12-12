<?php

namespace Architecture\External\Persistance\Queries\User;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Application\User\FirstData\GetUserQuery;
use Architecture\Domain\Creational\Creator;
use Architecture\Domain\Entity\UserEntitas;
use Architecture\External\Persistance\ORM\User as UserModel;
use Architecture\Shared\TypeData;
use Illuminate\Database\Eloquent\Collection;

class GetUserQueryHandler extends Query
{
    public function __construct() {}

    public function handle(GetUserQuery $query)
    {
        $data = UserModel::where('id',$query->GetId())->first();
        if($query->getOption()==TypeData::Default) return new Collection($data);

        return Creator::buildUser(UserEntitas::make($data->id,$data->name,$data->username,null,null,$data->level,));
    }
}