<?php

namespace Architecture\External\Datatable\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Matriks\List\GetAllMatriksQuery;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables as DataTables;

class DatatableMatriksController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function index(Request $request){
        $q = new GetAllMatriksQuery();
        // $q->SetOffset($request->get('start')??null)->SetLimit($request->get('length')??null);
        
        $listMatriks = $this->queryBus->ask($q);
        $listMatriks = $listMatriks->map(fn($item)=>(object)[
            "id"=>$item->GetId(),
            "nama"=>$item->GetNama(),
            "deskripsi"=>$item->GetDeskripsi()
        ]);
        
        return DataTables::of($listMatriks)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
            $actionBtn = '
            <a href="'.route('matriks.edit',['id'=>$row->id]).'" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
            <a href="'.route('matriks.delete',['id'=>$row->id]).'" class="btn btn-danger"><i class="bi bi-trash"></i></a>
            ';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
