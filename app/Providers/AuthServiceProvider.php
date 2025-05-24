<?php

namespace App\Providers;

use App\Models\Certificate;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education; // Adicione esta linha
use App\Policies\CertificatePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\ExperiencePolicy;
use App\Policies\EducationPolicy; // Adicione esta linha
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
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        Certificate::class => CertificatePolicy::class,
        Experience::class => ExperiencePolicy::class,
        Education::class => EducationPolicy::class, // Adicionado
        // Adicione outras policies aqui conforme são criadas
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
