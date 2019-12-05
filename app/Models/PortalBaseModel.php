<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PortalBaseModel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $auditExclude = [
        'created_at',
        'updated_at',
        'user_created_id',
        'user_created_ip',
        'user_updated_ip',
        'user_updated_id',
    ];

    /**
     * @return mixed
     */
    public function routeNotificationForSlack()
    {
        return env('SLACK_HOOK');
    }
}
