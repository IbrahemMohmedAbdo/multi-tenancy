<?php

namespace App\Services;

use DB;
use App\Models\Tenant;
use Illuminate\Validation\ValidationException;

class TenantService
{
    private $tenant;
    private $domain;
    private $database;

    public static function switchToTenant(Tenant $tenant)
    {
        if (!($tenant instanceof Tenant)) {
            throw ValidationException::withMessages(['field_name' => 'This value is incorrect']);
        }

        DB::purge('landlord');
        DB::purge('tenant');
        config(['database.connections.tenant.database' => $tenant->database]);
        $self = new self;
        $self->tenant = $tenant;
        $self->domain = $tenant->domain;
        $self->database = $tenant->database;
        DB::connection('tenant')->reconnect();
        DB::setDefaultConnection('tenant');
    }

    public function switchToDefault()
    {
        DB::purge('landlord');
        DB::purge('tenant');
        DB::connection('landlord')->reconnect();
        DB::setDefaultConnection('landlord');
    }

    public function getTenant()
    {
        return $this->tenant;
    }
}
