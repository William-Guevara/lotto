<?php

namespace App\Http\Controllers\Api;

use App\Models\Audit_Trail;
use Illuminate\Support\Facades\Auth;

class AuditTrailController
{

    public function audittrail()
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        //$role = $user->permission->code;

        $date = new \DateTime();
        $date->modify('-5 hours');
        $date = $date->format("Y-m-d H:i:s");


        //TODO:: Demas validaciones del usuario
        $audit = new Audit_Trail;
        $audit->date_time = $date;
        $audit->user_id = $user->id;
        $audit->action = 1;
        $audit->entity = "Modelo";
        $audit->record_id = 1;
        $audit->detail = "Detalle";
        $audit->save();
    }
}
