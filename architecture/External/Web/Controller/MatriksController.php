<?php

namespace Architecture\External\Web\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Matriks\Create\CreateMatriksCommand;
use Architecture\Application\Matriks\Delete\DeleteMatriksCommand;
use Architecture\Application\Matriks\FirstData\GetMatriksQuery;
use Architecture\Application\Matriks\Update\UpdateMatriksCommand;
use Architecture\Domain\Enum\TypeNotif;
use Architecture\Domain\RuleValidationRequest\Rule\CreateMatriksRuleReq;
use Architecture\Domain\RuleValidationRequest\Rule\UpdateMatriksRuleReq;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MatriksController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function Index(){
        return view('matriks.index');
    }

    public function create(){
        return view('matriks.create');
    }
    public function store(Request $request){
        try {
            $validator      = validator($request->all(), CreateMatriksRuleReq::create());

            if(count($validator->errors())){
                return redirect()->route('matriks.create')->withInput()->withErrors($validator->errors()->toArray());    
            } 
            
            $this->commandBus->dispatch(new CreateMatriksCommand(
                $request->get('nama'),
                $request->get('deskripsi'),
            ));
            Session::flash(TypeNotif::Create->val(), "berhasil simpan data matriks");

            return redirect()->route('matriks.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('matriks.create')->withInput();
        }
    }
    public function edit($id){
        try {
            $matriks = $this->queryBus->ask(new GetMatriksQuery($id));
            
            return view('matriks.edit',[
                "matriks"=>$matriks
            ]);
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('matriks.index');
        }
    }
    public function update(Request $request){
        try {
            $validator      = validator($request->all(), UpdateMatriksRuleReq::create());

            if(count($validator->errors())){
                return redirect()->route('matriks.edit',["id"=>$request->get("id")])->withInput()->withErrors($validator->errors()->toArray());    
            } 
            
            $this->commandBus->dispatch(new UpdateMatriksCommand(
                $request->get('id'), 
                $request->get('nama'), 
                $request->get('deskripsi'), 
            ));
            Session::flash(TypeNotif::Update->val(), "berhasil ubah data");

            return redirect()->route('matriks.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('matriks.edit',["id"=>$request->get('id')])->withInput();
        }
    }
    public function delete($id){
        try {
            if(empty($id)){
                throw new Exception("data referensi hapus tidak boleh kosong");
            }
            $this->commandBus->dispatch(new DeleteMatriksCommand($id));
            Session::flash(TypeNotif::Create->val(), "berhasil hapus data");

            return redirect()->route('matriks.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('matriks.index');
        }
    }
}
