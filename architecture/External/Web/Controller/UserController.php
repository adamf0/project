<?php

namespace Architecture\External\Web\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\User\Create\CreateUserCommand;
use Architecture\Application\User\Delete\DeleteUserCommand;
use Architecture\Application\User\FirstData\GetUserQuery;
use Architecture\Application\User\Update\UpdateUserCommand;
use Architecture\Domain\Enum\TypeNotif;
use Architecture\Domain\RuleValidationRequest\Rule\CreateUserRuleReq;
use Architecture\Domain\RuleValidationRequest\Rule\UpdateUserRuleReq;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function Index(){
        return view('user.index');
    }

    public function create(){
        return view('user.create');
    }
    public function store(Request $request){
        try {
            $validator      = validator($request->all(), CreateUserRuleReq::create());

            if(count($validator->errors())){
                return redirect()->route('user.create')->withInput()->withErrors($validator->errors()->toArray());    
            } 
            
            $this->commandBus->dispatch(new CreateUserCommand(
                $request->get('nama'),
                $request->get('username'),
                $request->get('password'),
                $request->get('level'),
            ));
            Session::flash(TypeNotif::Create->val(), "berhasil simpan data user");

            return redirect()->route('user.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('user.create')->withInput();
        }
    }
    public function edit($id){
        try {
            $user = $this->queryBus->ask(new GetUserQuery($id));
            
            return view('user.edit',[
                "user"=>$user
            ]);
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('user.index');
        }
    }
    public function update(Request $request){
        try {
            $validator      = validator($request->all(), UpdateUserRuleReq::create());

            if(count($validator->errors())){
                return redirect()->route('user.edit',["id"=>$request->get("id")])->withInput()->withErrors($validator->errors()->toArray());    
            } 
            
            $this->commandBus->dispatch(new UpdateUserCommand(
                $request->get('id'), 
                $request->get('nama'),
                $request->get('username'),
                $request->get('password'),
                $request->get('level'),
            ));
            Session::flash(TypeNotif::Update->val(), "berhasil ubah data");

            return redirect()->route('user.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('user.edit',["id"=>$request->get('id')])->withInput();
        }
    }
    public function delete($id){
        try {
            if(empty($id)){
                throw new Exception("data referensi hapus tidak boleh kosong");
            }
            $this->commandBus->dispatch(new DeleteUserCommand($id));
            Session::flash(TypeNotif::Create->val(), "berhasil hapus data");

            return redirect()->route('user.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('user.index');
        }
    }
}
