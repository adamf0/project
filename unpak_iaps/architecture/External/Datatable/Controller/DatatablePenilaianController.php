<?php

namespace Architecture\External\Datatable\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Penilaian\List\GetAllPenilaianQuery;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables as DataTables;

class DatatablePenilaianController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function index(Request $request){
        $q = new GetAllPenilaianQuery($request->get('tahun'));
        // $q->SetOffset($request->get('start')??null)->SetLimit($request->get('length')??null);
        
        $listPenilaian = $this->queryBus->ask($q);
        $listPenilaian = $listPenilaian->map(function($item){
            return (object)[
                "nama_matriks"=>$item->GetMatriks()?->GetNama(),
                "deskripsi"=>$item->GetMatriks()?->GetDeskripsi(),
                "berkas"=> $item->GetBerkas()->map(fn($child)=> $child->toArray())->toArray()
            ];
        });
        
        return DataTables::of($listPenilaian)
        ->addIndexColumn()
        ->addColumn('berkas_render', function ($row) use($request){
            $output = "";
            foreach($row->berkas as $berkas){
                if($request->get('level')!="guest"){
                    $output .= "
                    <li class='list-group-item'>
                        <div class='d-flex flex-wrap align-content-center justify-content-between'>
                                <a href='".$berkas['url']."' target='_blank' class='col-6'>".$berkas['nama_berkas']."</a>
                                <div class='col-6'>
                                    <div class='d-flex flex-wrap gap-2 justify-content-end'>
                                        <a href='".route("penilaian.edit",["id"=>$berkas["id"]])."' class='btn btn-sm btn-warning'>Edit</a> 
                                        <a href='".route("penilaian.delete",["id"=>$berkas["id"]])."' class='btn btn-sm btn-danger'>Delete</a>
                                    </div>
                                </div>
                            </div>
                    </li>";
                } else{
                    $output .= "
                    <li class='list-group-item'>
                        <a href='".$berkas['url']."' target='_blank' class='col-6'>".$berkas['nama_berkas']."</a>
                    </li>";
                }

            }
            if($request->get('level')!="guest"){
                $output .= "
                <li class='list-group-item'>
                    <a href='#' class='btn btn-primary btn-sm btn-add'>Tambah</a>
                </li>";
            } else if(empty($output) && $request->get('level')=="guest"){
                $output .= "
                <li class='list-group-item'>
                    Tidak ada berkas
                </li>";
            }
            $html = "<ul class='list-group' style='max-width: 500px !important;'>$output</ul>";
            return $html;
        })
        ->rawColumns(['berkas_render'])
        ->make(true);
    }
}
