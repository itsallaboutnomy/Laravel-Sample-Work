<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller {
    //
    public function index()
    {

        return
            \DB::select('select a.name Application, DATE_FORMAT(s.created_at, "%Y/%m/%d") "Subscription Date", d.os as OS,
            CASE
            WHEN s.status = "STARTED" THEN "New"
            WHEN s.status = "RENEWED" THEN "Renewed"
            WHEN s.status = "CANCELED" THEN "Expired"
            else s.status
            END as Status
            , COUNT(*) Total from subscriptions s
            inner join devices d on d.id = s.device_id
            inner join applications a on d.app_id = a.id
            group by a.id, s.created_at, d.os, s.status');
    }
}
