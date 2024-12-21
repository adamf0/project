<?php

namespace Architecture\External\Config\Provider;

use Architecture\Application\Abstractions\Messaging\CommandBusImpl;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Abstractions\Messaging\QueryBusImpl;
use Architecture\Application\DokumenInduk\Create\CreateDokumenIndukCommand;
use Architecture\Application\DokumenInduk\Create\CreateDokumenIndukCommandHandler;
use Architecture\Application\DokumenInduk\Delete\DeleteDokumenIndukCommand;
use Architecture\Application\DokumenInduk\Delete\DeleteDokumenIndukCommandHandler;
use Architecture\Application\DokumenInduk\FirstData\GetDokumenIndukQuery;
use Architecture\Application\DokumenInduk\List\GetAllDokumenIndukQuery;
use Architecture\Application\DokumenInduk\Update\UpdateDokumenIndukCommand;
use Architecture\Application\DokumenInduk\Update\UpdateDokumenIndukCommandHandler;
use Architecture\External\Persistance\Queries\DokumenInduk\GetAllDokumenIndukQueryHandler;
use Architecture\External\Persistance\Queries\DokumenInduk\GetDokumenIndukQueryHandler;
use Illuminate\Support\ServiceProvider;

class DokumenIndukServiceProvider extends ServiceProvider
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
            CreateDokumenIndukCommand::class => CreateDokumenIndukCommandHandler::class,
            UpdateDokumenIndukCommand::class => UpdateDokumenIndukCommandHandler::class,
            DeleteDokumenIndukCommand::class => DeleteDokumenIndukCommandHandler::class,
        ]);

        app(QueryBusImpl::class)->register([
            GetAllDokumenIndukQuery::class => GetAllDokumenIndukQueryHandler::class,
            GetDokumenIndukQuery::class => GetDokumenIndukQueryHandler::class,
        ]);

        if(env('DEPLOY','dev')=='prod'){
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
            
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
    }
}
