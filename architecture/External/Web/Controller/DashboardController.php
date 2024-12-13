<?php

namespace Architecture\External\Web\Controller;

use App\Http\Controllers\Controller;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Exception;
use Architecture\Shared\Facades\Utility;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}
    
    public function Index(){     
        if(Session::get("level")=="guest"){
            return redirect()->route("penilaian.index");
        }   
        return view('dashboard.index');
    }
}
