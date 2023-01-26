<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/daftar/baru',
        '/user',
        '/data',
        '/edit/data',
        '/lab/data',
        '/edit_user/edit',
        '/masukLab/dok',
        '/lab/edit/data',
        '/lab/edit/hapus'
    ];
}
