<?php

namespace Architecture\External\Api\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Penilaian\Create\CreatePenilaianCommand;
use Architecture\Domain\RuleValidationRequest\Rule\CreatePenilaianRuleReq;
use Exception;
use Illuminate\Http\Request;

class ApiPenilaianController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function create(Request $request){
        try {
            $validator      = validator($request->all(), CreatePenilaianRuleReq::create());

            if(count($validator->errors())){
                dd($validator->errors()->toArray());
            } 
            
            $this->commandBus->dispatch(new CreatePenilaianCommand(
                $request->get('matriks'),
                $request->get('nama_berkas'),
                $request->get('url'),
                $request->get('tahun'),
            ));

            return response()->json(["status"=>"ok","message"=>"berhasil ditambah","log"=>""]);
        } catch (Exception $e) {
            return response()->json(["status"=>"fail","message"=>"gagal tambah data","log"=>$e->getTrace()]);
        }
    }
}
