<?php

namespace Architecture\External\Persistance\Queries\Penilaian;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Application\Penilaian\List\GetAllPenilaianQuery;
use Architecture\Domain\Creational\Creator;
use Architecture\Domain\Entity\Matriks;
use Architecture\Domain\Entity\PenilaianEntitas;
use Architecture\External\Persistance\ORM\Penilaian as PenilaianModel;
use Architecture\Shared\TypeData;
use Illuminate\Database\Eloquent\Collection;

class GetAllPenilaianQueryHandler extends Query
{
    public function __construct() {}

    public function handle(GetAllPenilaianQuery $query)
    {
        // if($query->HasPaging())
        //     $datas = PenilaianModel::with(["Matriks"])->offset($query->GetOffset())->limit($query->GetLimit())->get();
        // else
            $datas = PenilaianModel::with(["Matriks"])->get();

            $record = collect($datas)
                ->filter(fn($data) => $data?->Matriks !== null)  // Menyaring data yang Matriks-nya tidak null
                ->groupBy(fn($data) => $data->Matriks->nama)  // Mengelompokkan berdasarkan nama Matriks
                ->flatMap(fn($group, $nama_matriks) => collect([ // Menggunakan koleksi
                    collect([ // Menggunakan koleksi untuk setiap grup
                        'nama_matriks' => $nama_matriks,
                        'berkas' => collect($group)->map(fn($data) => collect([ // Menggunakan koleksi untuk berkas
                            'id' => $data->id,
                            'url' => $data->url,
                            'nama_berkas' => $data->nama_berkas
                        ]))  // Membuat koleksi dari array berkas
                    ])
                ]));

        if($query->getOption()==TypeData::Default) return new Collection($datas);

        return $record->transform( function($data){
            return Creator::buildPenilaian(PenilaianEntitas::make(null,new Matriks(null, $data["nama_matriks"], null),null,null,$data["berkas"]));
        });
    }
}