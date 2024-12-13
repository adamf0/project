<?php

namespace Architecture\External\Persistance\Queries\Penilaian;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Application\Penilaian\FirstData\GetPenilaianQuery;
use Architecture\Domain\Creational\Creator;
use Architecture\Domain\Entity\Matriks;
use Architecture\Domain\Entity\PenilaianEntitas;
use Architecture\External\Persistance\ORM\Penilaian as PenilaianModel;
use Architecture\Shared\TypeData;
use Illuminate\Database\Eloquent\Collection;

class GetPenilaianQueryHandler extends Query
{
    public function __construct() {}

    public function handle(GetPenilaianQuery $query)
    {
        $data = PenilaianModel::with(["Matriks"])->where('id',$query->GetId())->first();
        if($query->getOption()==TypeData::Default) return new Collection($data);

        return Creator::buildPenilaian(PenilaianEntitas::make(
            $data->id,
            $data?->Matriks==null? null:new Matriks($data?->Matriks?->id, $data?->Matriks?->nama, $data?->Matriks?->deskripsi),
            $data->nama_berkas, 
            $data->url, 
            $data->file, 
            $data->tahun, 
            collect([])
        ));
    }
}