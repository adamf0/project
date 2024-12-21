<?php

namespace Architecture\External\Web\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Abstractions\Pattern\OptionFileDefault;
use Architecture\Application\DokumenInduk\Delete\DeleteDokumenIndukCommand;
use Architecture\Application\DokumenInduk\FirstData\GetDokumenIndukQuery;
use Architecture\Application\DokumenInduk\Update\UpdateDokumenIndukCommand;
use Architecture\Domain\Enum\TypeNotif;
use Architecture\Domain\RuleValidationRequest\Rule\UpdateDokumenIndukRuleReq;
use Architecture\External\Port\FileSystem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DokumenIndukController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function Index(){
        return view('dokumen_induk.index');
    }

    // public function create(){
    //     return view('dokumen_induk.create');
    // }
    // public function store(Request $request){
    //     try {
    //         $validator      = validator($request->all(), CreateDokumenIndukRuleReq::create());

    //         if(count($validator->errors())){
    //             return redirect()->route('dokumenInduk.create')->withInput()->withErrors($validator->errors()->toArray());    
    //         } 
            
    //         $file = null;
    //         if($request->has("file")){
    //             $fileSystem = new FileSystem(new OptionFileDefault($request->file("file"), "berkas"));
    //             $file = $fileSystem->storeFileWithReplaceFileAndReturnFileLocation();
    //         }

    //         $this->commandBus->dispatch(new CreateDokumenIndukCommand(
    //             $request->get('nama_berkas'),
    //             $request->get('url'),
    //             $file,
    //             $request->get('tahun'),
    //         ));
    //         Session::flash(TypeNotif::Create->val(), "berhasil simpan data penilaian");

    //         return redirect()->route('dokumenInduk.index');
    //     } catch (Exception $e) {
    //         Session::flash(TypeNotif::Error->val(), $e->getMessage());
    //         return redirect()->route('dokumenInduk.create')->withInput();
    //     }
    // }
    public function edit($id){
        try {
            $penilaian = $this->queryBus->ask(new GetDokumenIndukQuery($id));
            
            return view('dokumen_induk.edit',[
                "penilaian"=>$penilaian
            ]);
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('dokumenInduk.index');
        }
    }
    public function update(Request $request){
        try {
            $validator      = validator($request->all(), UpdateDokumenIndukRuleReq::create());

            if(count($validator->errors())){
                return redirect()->route('dokumenInduk.edit',["id"=>$request->get("id")])->withInput()->withErrors($validator->errors()->toArray());    
            } 
            
            $file = null;
            if($request->has("file")){
                $fileSystem = new FileSystem(new OptionFileDefault($request->file("file"), "dokumen_induk"));
                $file = $fileSystem->storeFileWithReplaceFileAndReturnFileLocation();
            }

            $this->commandBus->dispatch(new UpdateDokumenIndukCommand(
                $request->get('id'), 
                $request->get('nama_berkas'),
                $request->get('url'),
                $file,
                $request->get('tahun'),
            ));
            Session::flash(TypeNotif::Update->val(), "berhasil ubah data");

            return redirect()->route('dokumenInduk.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('dokumenInduk.edit',["id"=>$request->get('id')])->withInput();
        }
    }
    public function delete($id){
        $request = request()->merge(["id"=> $id]);
        try {
            if(empty($id)){
                throw new Exception("data referensi hapus tidak boleh kosong");
            }            
            $this->commandBus->dispatch(new DeleteDokumenIndukCommand($id));
            Session::flash(TypeNotif::Create->val(), "berhasil hapus data");

            return redirect()->route('dokumenInduk.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('dokumenInduk.index');
        }
    }
}
