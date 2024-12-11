<?php

namespace Architecture\External\Web\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Auth\Attempt\AuthenticationCommand;
use Architecture\Application\Auth\Attempt\LogOutCommand;
use Architecture\Domain\Enum\TypeNotif;
use Architecture\External\Persistance\ORM\User as ModelUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Architecture\Shared\Facades\Utility;

class AuthController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function Authorization(){
        return view('authorization');
    }
    public function Authentication(Request $request){
        try {
            // $validator      = validator($request->all(), LoginRuleReq::login());

            // if(count($validator->errors())){
            //     return redirect()->route('auth.authorization')->withInput()->withErrors($validator->errors()->toArray());
            // }

            $user = ModelUser::where("username",$request->username)
                        ->where("plain_password",$request->password)
                        ->first();

            if($user==null) throw new Exception("akses ditolak");

            session()->put("id",$user->id);
            session()->put("name",$user->name);
            session()->put("level",$user->level);

            return redirect()->route('dashboard.index');
        } catch (Exception $e) {
            Session::flash(TypeNotif::Error->val(), $e->getMessage());
            return redirect()->route('auth.authorization')->withInput()->withErrors(['alert-danger' => $e->getMessage()]);
        }
    }
    public function LogOut(Request $request){
        $target = Utility::isAlterMode()? 'dashboard.index':'auth.authorization';
        
        $request->session()->flush();
        
        // if($request->debug==1){
        //     dd(Session::all());
        // }
        return redirect()->route($target);
    }
}
