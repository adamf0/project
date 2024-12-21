<?php

namespace Architecture\External\Persistance\Queries\DokumenInduk;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Application\DokumenInduk\List\GetAllDokumenIndukQuery;
use Architecture\Domain\Creational\Creator;
use Architecture\Domain\Entity\DokumenIndukEntitas;
use Architecture\External\Persistance\ORM\DokumenInduk as DokumenIndukModel;
use Architecture\Shared\TypeData;
use Illuminate\Database\Eloquent\Collection;

class GetAllDokumenIndukQueryHandler extends Query
{
    public function __construct() {}

    public function handle(GetAllDokumenIndukQuery $query)
    {
        // if($query->HasPaging())
        //     $datas = DokumenIndukModel::with(["Matriks"])->offset($query->GetOffset())->limit($query->GetLimit())->get();
        // else

        $datas = DokumenIndukModel::all();

        if($query->getOption()==TypeData::Default) return new Collection($datas);

        return $datas->transform( function($data){
            return Creator::buildDokumenInduk(DokumenIndukEntitas::make(
                $data->id,
                $data->nama_berkas,
                $data->url,
                $data->file,
            ));
        });
    }
}