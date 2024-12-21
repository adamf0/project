<?php

namespace Architecture\External\Datatable\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\DokumenInduk\List\GetAllDokumenIndukQuery;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables as DataTables;
use Architecture\Shared\Facades\Utility;

class DatatableDokumenIndukController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function index(Request $request){
        $q = new GetAllDokumenIndukQuery($request->get('tahun'));
        // $q->SetOffset($request->get('start')??null)->SetLimit($request->get('length')??null);
        
        $listDokumenInduk = $this->queryBus->ask($q);
        $listDokumenInduk = $listDokumenInduk->map(function($item){
            return (object)[
                "id"=>$item->GetId(),
                "nama_berkas"=>$item->GetNamaBerkas(),
                "berkas"=> empty($item->GetFile())? $item->GetUrl():Utility::loadAsset("dokumen_induk/".$item->GetFile())
            ];
        });
        
        return DataTables::of($listDokumenInduk)
        ->addIndexColumn()
        ->addColumn('berkas_render', function ($row) use($request){
            return "<a href='".$row->berkas."' target='_blank'>".$row->nama_berkas."</a>";
        })
        ->addColumn('action_render', function ($row) use($request){
            return "<div class='d-flex flex-wrap gap-2'>
                        <a href='".route("dokumenInduk.edit",["id"=>$row->id])."' class='btn btn-sm btn-warning'>Edit</a> 
                        <a href='".route("dokumenInduk.delete",["id"=>$row->id])."' class='btn btn-sm btn-danger'>Delete</a>
                    </div>";
        })
        ->rawColumns(['berkas_render','action_render'])
        ->make(true);
    }
}
