<?php

namespace Architecture\External\Api\Controller;

use App\Http\Controllers\Controller;
use Architecture\External\Persistance\ORM\Provinsi;
// use Architecture\Application\Abstractions\Messaging\ICommandBus;
// use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiAdministrasiAreaController extends Controller
{
    public function __construct(
        // protected ICommandBus $commandBus,
        // protected IQueryBus $queryBus
    ) {}
    
    public function list(Request $request){
        try {
            $list = Provinsi::with(["Kota"])->get()->transform(fn($items)=> [
                "id"=>$items->id,
                "text"=>$items->name,
                "kota"=>$items->kota->transform(fn($items)=> [
                    "id"=>$items->id,
                    "text"=>$items->name
                ]),
            ]);
            return response()->json([
                "status"=>"ok",
                "message"=>"",
                "data"=>$list,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "status"=>"fail",
                "message"=>$e->getMessage(),
                "data"=>null,
            ]);
        }
    }
}
