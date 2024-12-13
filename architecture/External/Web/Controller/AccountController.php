<?php

namespace Architecture\External\Web\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\User\FirstData\GetUserQuery;
use Architecture\Application\User\Update\UpdateUserCommand;
use Architecture\Domain\Enum\TypeNotif;
use Architecture\Domain\RuleValidationRequest\Rule\UpdateAccountRuleReq;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function index(){
        try {
            $account = $this->queryBus->ask(new GetUserQuery(Session::get("id")));
            
            return view('account.index',[
                "account"=>$account
            ]);
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            throw $e;
        }
    }
    public function update(Request $request){
        try {
            $validator      = validator($request->all(), UpdateAccountRuleReq::create());

            if(count($validator->errors())){
                return redirect()->route('account.index')->withInput()->withErrors($validator->errors()->toArray());    
            } 
            
            $this->commandBus->dispatch(new UpdateUserCommand(
                Session::get("id"), 
                $request->get('nama'),
                $request->get('username'),
                $request->get('password'),
                null
            ));
            Session::flash(TypeNotif::Update->val(), "berhasil ubah data");

            return redirect()->route('account.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('account.index')->withInput();
        }
    }
}
