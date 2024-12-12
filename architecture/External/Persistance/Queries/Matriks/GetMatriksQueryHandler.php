<?php

namespace Architecture\External\Persistance\Queries\Matriks;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Application\Matriks\FirstData\GetMatriksQuery;
use Architecture\Domain\Creational\Creator;
use Architecture\Domain\Entity\MatriksEntitas;
use Architecture\External\Persistance\ORM\Matriks as MatriksModel;
use Architecture\Shared\TypeData;
use Illuminate\Database\Eloquent\Collection;

class GetMatriksQueryHandler extends Query
{
    public function __construct() {}

    public function handle(GetMatriksQuery $query)
    {
        $data = MatriksModel::where('id',$query->GetId())->first();
        if($query->getOption()==TypeData::Default) return new Collection($data);

        return Creator::buildMatriks(MatriksEntitas::make($data->id,$data->nama,$data->deskripsi));
    }
}