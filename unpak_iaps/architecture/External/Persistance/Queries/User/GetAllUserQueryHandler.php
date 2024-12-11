<?php

namespace Architecture\External\Persistance\Queries\User;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Application\User\List\GetAllUserQuery;
use Architecture\Domain\Creational\Creator;
use Architecture\Domain\Entity\UserEntitas;
use Architecture\External\Persistance\ORM\User as UserModel;
use Architecture\Shared\TypeData;
use Illuminate\Database\Eloquent\Collection;

class GetAllUserQueryHandler extends Query
{
    public function __construct() {}

    public function handle(GetAllUserQuery $query)
    {
        if($query->HasPaging())
            $datas = UserModel::offset($query->GetOffset())->limit($query->GetLimit())->get();
        else
            $datas = UserModel::get();

        if($query->getOption()==TypeData::Default) return new Collection($datas);
        return $datas->transform( function($data){
            return Creator::buildUser(UserEntitas::make($data->id,$data->name,$data->username,null,null,$data->level,));
        } );
    }
}