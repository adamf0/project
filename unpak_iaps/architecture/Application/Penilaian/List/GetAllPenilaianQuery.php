<?php

namespace Architecture\Application\Penilaian\List;

use Architecture\Application\Abstractions\Messaging\Query;
use Architecture\Shared\PagingQuery;
use Architecture\Shared\TypeData;

class GetAllPenilaianQuery extends Query
{
    use PagingQuery;
    public function __construct(
        public $tahun=null,
        public TypeData $option = TypeData::Entity
    ) {
        return $this;
    }

    public function GetTahun(){
        return $this->tahun;
    }
}