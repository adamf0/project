<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'verificationMemberPenelitianInternal',
        'verificationMemberPenelitianNasional',
        'verificationMemberPKM',
        'verificationMemberPKMNasional',
        'fundingPenelitianInternal',
        'fundingPenelitianNasional',
        'fundingPKM',
        'fundingPKMNasional',
        'tes',
        'penelitianInternal/updateStep1',
        'pkm/updateStep1'
    ];
}
