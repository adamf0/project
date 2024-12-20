<?php

namespace Architecture\External\Persistance\Queries\Penilaian;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Application\Penilaian\List\GetAllPenilaianQuery;
use Architecture\Domain\Creational\Creator;
use Architecture\Domain\Entity\Matriks;
use Architecture\Domain\Entity\PenilaianEntitas;
use Architecture\External\Persistance\ORM\Matriks as MatriksModel;
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

        $datas = [];
        $matriks = MatriksModel::all();
        foreach($matriks as $matrik){
            $penilaian = PenilaianModel::where("id_matriks",$matrik->id);
            if(!empty($query->GetTahun())){
                $penilaian = $penilaian->where("tahun",$query->GetTahun());
            }
            $penilaian = $penilaian->get();

            $datas[$matrik->nama."#".$matrik->id] = $penilaian->count()? $penilaian->toArray():[];
        }

        $record = collect($datas)
                    ->flatMap(function($group, $nama_matriks){
                        [$nama_matriks_,$id] = explode("#",$nama_matriks);
                        $data = MatriksModel::find($id);

                        return collect([ // Menggunakan koleksi
                            collect([ // Menggunakan koleksi untuk setiap grup
                                'id' => $id,
                                'nama_matriks' => $nama_matriks_,
                                'deskripsi' => $data?->deskripsi,
                                'berkas' => collect($group)->map(function($data) {
                                    return collect($data);
                                } )  // Membuat koleksi dari array berkas
                            ])
                        ]);
                    });

        if($query->getOption()==TypeData::Default) return new Collection($datas);

        return $record->transform( function($data){
            return Creator::buildPenilaian(PenilaianEntitas::make(null,new Matriks($data["id"], $data["nama_matriks"], $data["deskripsi"]),null,null,null,null,$data["berkas"]));
        });
    }
}