<?php

namespace Architecture\External\Persistance\Queries\DokumenInduk;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Application\DokumenInduk\FirstData\GetDokumenIndukQuery;
use Architecture\Domain\Creational\Creator;
use Architecture\Domain\Entity\Matriks;
use Architecture\Domain\Entity\DokumenIndukEntitas;
use Architecture\External\Persistance\ORM\DokumenInduk as DokumenIndukModel;
use Architecture\Shared\TypeData;
use Illuminate\Database\Eloquent\Collection;

class GetDokumenIndukQueryHandler extends Query
{
    public function __construct() {}

    public function handle(GetDokumenIndukQuery $query)
    {
        $data = DokumenIndukModel::where('id',$query->GetId())->first();
        if($query->getOption()==TypeData::Default) return new Collection($data);

        return Creator::buildDokumenInduk(DokumenIndukEntitas::make(
            $data->id,
            $data->nama_berkas, 
            $data->url, 
            $data->file, 
        ));
    }
}