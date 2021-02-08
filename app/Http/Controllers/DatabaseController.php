<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    /**
     * Truncate Database.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        \DB::statement("SET foreign_key_checks=0");
        $databaseName = \DB::getDatabaseName();
        $tables = \DB::select("SELECT * FROM information_schema.tables WHERE table_schema = '$databaseName'");
        foreach ($tables as $table) {
            $name = $table->TABLE_NAME;
            //if you don't want to truncate migrations
            if ($name == 'migrations') {
                continue;
            }
            \DB::table($name)->truncate();
        }
        \DB::statement("SET foreign_key_checks=1");

    }


}
