<?php

namespace Architecture\Application\Matriks\FirstData;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Shared\IdentityCommand;
use Architecture\Shared\TypeData;

class GetMatriksQuery extends Query
{
    use IdentityCommand;
    public function __construct(
        public $id,
        public TypeData $option = TypeData::Entity,
    ) {}
}