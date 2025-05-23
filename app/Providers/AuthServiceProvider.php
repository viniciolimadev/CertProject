<?php

namespace App\Providers;

use App\Models\Certificate;
use App\Models\Project;
use App\Policies\CertificatePolicy;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    protected $policies = [
        \App\Models\Project::class => \App\Policies\ProjectPolicy::class,
        Certificate::class => CertificatePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
