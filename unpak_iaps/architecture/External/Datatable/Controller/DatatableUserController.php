<?php

namespace Architecture\External\Datatable\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\User\List\GetAllUserQuery;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables as DataTables;

class DatatableUserController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function index(Request $request){
        $q = new GetAllUserQuery();
        // $q->SetOffset($request->get('start')??null)->SetLimit($request->get('length')??null);
        
        $listUser = $this->queryBus->ask($q);
        $listUser = $listUser->map(fn($item)=>(object)[
            "id"=>$item->GetId(),
            "nama"=>$item->GetNama(),
            "username"=>$item->GetUsername(),
            "level"=>$item->GetLevel()
        ]);
        
        return DataTables::of($listUser)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
            $actionBtn = '
            <a href="'.route('user.edit',['id'=>$row->id]).'" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
            <a href="'.route('user.delete',['id'=>$row->id]).'" class="btn btn-danger"><i class="bi bi-trash"></i></a>
            ';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
