<?php

namespace Architecture\External\Config\Provider;

use Architecture\Application\Abstractions\Messaging\CommandBusImpl;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Abstractions\Messaging\QueryBusImpl;
use Architecture\Application\Matriks\Create\CreateMatriksCommand;
use Architecture\Application\Matriks\Create\CreateMatriksCommandHandler;
use Architecture\Application\Matriks\Delete\DeleteMatriksCommand;
use Architecture\Application\Matriks\Delete\DeleteMatriksCommandHandler;
use Architecture\Application\Matriks\FirstData\GetMatriksQuery;
use Architecture\Application\Matriks\List\GetAllMatriksQuery;
use Architecture\Application\Matriks\Update\UpdateMatriksCommand;
use Architecture\Application\Matriks\Update\UpdateMatriksCommandHandler;
use Architecture\External\Persistance\Queries\Matriks\GetAllMatriksQueryHandler;
use Architecture\External\Persistance\Queries\Matriks\GetMatriksQueryHandler;
use Illuminate\Support\ServiceProvider;

class MatriksServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $singletons = [
            ICommandBus::class                      => CommandBusImpl::class,
            IQueryBus::class                        => QueryBusImpl::class,
        ];

        foreach ($singletons as $abstract => $concrete) $this->app->singleton($abstract,$concrete);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app(CommandBusImpl::class)->register([
            CreateMatriksCommand::class => CreateMatriksCommandHandler::class,
            UpdateMatriksCommand::class => UpdateMatriksCommandHandler::class,
            DeleteMatriksCommand::class => DeleteMatriksCommandHandler::class,
        ]);

        app(QueryBusImpl::class)->register([
            GetAllMatriksQuery::class => GetAllMatriksQueryHandler::class,
            GetMatriksQuery::class => GetMatriksQueryHandler::class,
        ]);

        if(env('DEPLOY','dev')=='prod'){
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
            
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
    }
}
