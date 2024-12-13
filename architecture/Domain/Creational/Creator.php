<?php
namespace Architecture\Domain\Creational;

use Architecture\Domain\Contract\IMatriks;
use Architecture\Domain\Contract\IPenilaian;
use Architecture\Domain\Contract\IUser;
use Architecture\Domain\Entity\Matriks;
use Architecture\Domain\Entity\Penilaian;
use Architecture\Domain\Entity\User;
use Architecture\Domain\Exception\NotImplementedException;

class Creator{
    public static function buildMatriks(IMatriks $factory){
        return new Matriks(
            $factory->GetId(),
            $factory->GetNama(),
            $factory->GetDeskripsi(),
        );
    }
    public static function buildPenilaian(IPenilaian $factory){
        return new Penilaian(
            $factory->GetId(),
            $factory->GetMatriks(),
            $factory->GetNamaBerkas(),
            $factory->GetUrl(),
            $factory->GetFile(),
            $factory->GetTahun(),
            $factory->GetBerkas(),
        );
    }
    public static function buildUser(IUser $factory){
        return new User(
            $factory->GetId(),
            $factory->GetNama(),
            $factory->GetUsername(),
            $factory->GetPassword(),
            $factory->GetPlainPassword(),
            $factory->GetLevel(),
        );
    }
}