<?php

namespace Architecture\External\Config\Provider;

use Architecture\Application\Abstractions\Messaging\CommandBusImpl;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Abstractions\Messaging\QueryBusImpl;
use Architecture\Application\Penilaian\Create\CreatePenilaianCommand;
use Architecture\Application\Penilaian\Create\CreatePenilaianCommandHandler;
use Architecture\Application\Penilaian\Delete\DeletePenilaianCommand;
use Architecture\Application\Penilaian\Delete\DeletePenilaianCommandHandler;
use Architecture\Application\Penilaian\FirstData\GetPenilaianQuery;
use Architecture\Application\Penilaian\List\GetAllPenilaianQuery;
use Architecture\Application\Penilaian\Update\UpdatePenilaianCommand;
use Architecture\Application\Penilaian\Update\UpdatePenilaianCommandHandler;
use Architecture\External\Persistance\Queries\Penilaian\GetAllPenilaianQueryHandler;
use Architecture\External\Persistance\Queries\Penilaian\GetPenilaianQueryHandler;
use Illuminate\Support\ServiceProvider;

class PenilaianServiceProvider extends ServiceProvider
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
            CreatePenilaianCommand::class => CreatePenilaianCommandHandler::class,
            UpdatePenilaianCommand::class => UpdatePenilaianCommandHandler::class,
            DeletePenilaianCommand::class => DeletePenilaianCommandHandler::class,
        ]);

        app(QueryBusImpl::class)->register([
            GetAllPenilaianQuery::class => GetAllPenilaianQueryHandler::class,
            GetPenilaianQuery::class => GetPenilaianQueryHandler::class,
        ]);

        if(env('DEPLOY','dev')=='prod'){
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
            
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
    }
}
