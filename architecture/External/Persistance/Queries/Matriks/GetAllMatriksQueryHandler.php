<?php

namespace Architecture\External\Persistance\Queries\Matriks;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Application\Matriks\List\GetAllMatriksQuery;
use Architecture\Domain\Creational\Creator;
use Architecture\Domain\Entity\MatriksEntitas;
use Architecture\External\Persistance\ORM\Matriks as MatriksModel;
use Architecture\Shared\TypeData;
use Illuminate\Database\Eloquent\Collection;

class GetAllMatriksQueryHandler extends Query
{
    public function __construct() {}

    public function handle(GetAllMatriksQuery $query)
    {
        if($query->HasPaging())
            $datas = MatriksModel::offset($query->GetOffset())->limit($query->GetLimit())->get();
        else
            $datas = MatriksModel::get();

        if($query->getOption()==TypeData::Default) return new Collection($datas);
        return $datas->transform( function($data){
            return Creator::buildMatriks(MatriksEntitas::make($data->id,$data->nama,$data->deskripsi));
        } );
    }
}