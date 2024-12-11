<?php

namespace Architecture\External\Select2\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Matriks\List\GetAllMatriksQuery;

class Select2MatriksController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function List(){
        $listMatriks = $this->queryBus->ask(new GetAllMatriksQuery());
        $listMatriks = $listMatriks->map(fn($matriks)=>["id"=>$matriks->GetId(),"text"=>$matriks->GetNama()]);

        return response()->json($listMatriks);
    }
}
