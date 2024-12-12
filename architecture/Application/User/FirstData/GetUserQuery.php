<?php

namespace Architecture\Application\User\FirstData;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Shared\IdentityCommand;
use Architecture\Shared\TypeData;

class GetUserQuery extends Query
{
    use IdentityCommand;
    public function __construct(
        public $id,
        public TypeData $option = TypeData::Entity,
    ) {}
}