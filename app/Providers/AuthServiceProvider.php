<?php

namespace App\Providers;

use App\Permission;
use App\Policies\StudentPolicy;
use App\Student;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Student::class => StudentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return bool
     */
    public function boot()
    {
        $this->registerPolicies();

        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                if ($permission->name === 'student-only' || $permission->name === 'guardian-only') {
                    return $user->hasRole($permission->roles);
                }

                if ($user->isAdmin() || $user->hasRole($permission->roles)) {
                    return true;
                }

                return false;
            });
        }
    }

    /**
     * Return all permissions with associated roles.
     *
     * @return Permission[]|Builder[]|Collection
     */
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
