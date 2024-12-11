<?php

namespace Architecture\External\Config\Provider;

use Architecture\Application\Abstractions\Messaging\CommandBusImpl;
use Architecture\Application\Abstractions\Messaging\ICommandBus;
use Architecture\Application\Abstractions\Messaging\IQueryBus;
use Architecture\Application\Abstractions\Messaging\QueryBusImpl;
use Architecture\Application\User\Create\CreateUserCommand;
use Architecture\Application\User\Create\CreateUserCommandHandler;
use Architecture\Application\User\Delete\DeleteUserCommand;
use Architecture\Application\User\Delete\DeleteUserCommandHandler;
use Architecture\Application\User\FirstData\GetUserQuery;
use Architecture\Application\User\List\GetAllUserQuery;
use Architecture\Application\User\Update\UpdateUserCommand;
use Architecture\Application\User\Update\UpdateUserCommandHandler;
use Architecture\External\Persistance\Queries\User\GetAllUserQueryHandler;
use Architecture\External\Persistance\Queries\User\GetUserQueryHandler;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
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
            CreateUserCommand::class => CreateUserCommandHandler::class,
            UpdateUserCommand::class => UpdateUserCommandHandler::class,
            DeleteUserCommand::class => DeleteUserCommandHandler::class,
        ]);

        app(QueryBusImpl::class)->register([
            GetAllUserQuery::class => GetAllUserQueryHandler::class,
            GetUserQuery::class => GetUserQueryHandler::class,
        ]);

        if(env('DEPLOY','dev')=='prod'){
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
            
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
    }
}
