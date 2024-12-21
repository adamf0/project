<?php

namespace Architecture\External\Api\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Abstractions\Pattern\OptionFileDefault;
use Architecture\Application\DokumenInduk\Create\CreateDokumenIndukCommand;
use Architecture\Domain\RuleValidationRequest\Rule\CreateDokumenIndukRuleReq;
use Architecture\External\Port\FileSystem;
use Exception;
use Illuminate\Http\Request;

class ApiDokumenIndukController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function create(Request $request){
        try {
            $validator      = validator($request->all(), CreateDokumenIndukRuleReq::create());

            if(count($validator->errors())){
                return $validator->errors();
            } 
            
            $file = null;
            if($request->has("file")){
                $fileSystem = new FileSystem(new OptionFileDefault($request->file("file"), "dokumen_induk"));
                $file = $fileSystem->storeFileWithReplaceFileAndReturnFileLocation();
            }

            $this->commandBus->dispatch(new CreateDokumenIndukCommand(
                $request->get('nama_berkas'),
                $request->get('url'),
                $file,
                $request->get('tahun'),
            ));

            return response()->json(["status"=>"ok","message"=>"berhasil ditambah","log"=>""]);
        } catch (Exception $e) {
            return response()->json(["status"=>"fail","message"=>"gagal tambah data","log"=>$e->getTrace()]);
        }
    }
}
