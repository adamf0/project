<?php

namespace Architecture\External\Web\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Penilaian\Create\CreatePenilaianCommand;
use Architecture\Application\Penilaian\Delete\DeletePenilaianCommand;
use Architecture\Application\Penilaian\FirstData\GetPenilaianQuery;
use Architecture\Application\Penilaian\Update\UpdatePenilaianCommand;
use Architecture\Domain\Enum\TypeNotif;
use Architecture\Domain\RuleValidationRequest\Rule\CreatePenilaianRuleReq;
use Architecture\Domain\RuleValidationRequest\Rule\UpdatePenilaianRuleReq;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PenilaianController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function Index(){
        return view('penilaian.index');
    }

    public function create(){
        return view('penilaian.create');
    }
    public function store(Request $request){
        try {
            $validator      = validator($request->all(), CreatePenilaianRuleReq::create());

            if(count($validator->errors())){
                return redirect()->route('penilaian.create')->withInput()->withErrors($validator->errors()->toArray());    
            } 
            
            $this->commandBus->dispatch(new CreatePenilaianCommand(
                $request->get('matriks'),
                $request->get('nama_berkas'),
                $request->get('url'),
                $request->get('tahun'),
            ));
            Session::flash(TypeNotif::Create->val(), "berhasil simpan data penilaian");

            return redirect()->route('penilaian.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('penilaian.create')->withInput();
        }
    }
    public function edit($id){
        try {
            $penilaian = $this->queryBus->ask(new GetPenilaianQuery($id));
            
            return view('penilaian.edit',[
                "penilaian"=>$penilaian
            ]);
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('penilaian.index');
        }
    }
    public function update(Request $request){
        try {
            $validator      = validator($request->all(), UpdatePenilaianRuleReq::create());

            if(count($validator->errors())){
                return redirect()->route('penilaian.edit',["id"=>$request->get("id")])->withInput()->withErrors($validator->errors()->toArray());    
            } 
            
            $this->commandBus->dispatch(new UpdatePenilaianCommand(
                $request->get('id'), 
                $request->get('matriks'),
                $request->get('nama_berkas'),
                $request->get('url'),
                $request->get('tahun'),
            ));
            Session::flash(TypeNotif::Update->val(), "berhasil ubah data");

            return redirect()->route('penilaian.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('penilaian.edit',["id"=>$request->get('id')])->withInput();
        }
    }
    public function delete($id){
        $request = request()->merge(["id"=> $id]);
        try {
            if(empty($id)){
                throw new Exception("data referensi hapus tidak boleh kosong");
            }            
            $this->commandBus->dispatch(new DeletePenilaianCommand($id));
            Session::flash(TypeNotif::Create->val(), "berhasil hapus data");

            return redirect()->route('penilaian.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('penilaian.index');
        }
    }
}
