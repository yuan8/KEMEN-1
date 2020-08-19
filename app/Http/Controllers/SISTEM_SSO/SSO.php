<?php

namespace App\Http\Controllers\SISTEM_SSO;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MySSOServer;

class SSO extends Controller
{
    //
    public function index(MySSOServer $ssoServer){
        $command = isset($_REQUEST['command']) ? $_REQUEST['command'] : null;
        if (!$command || !method_exists($ssoServer, $command)) {
            header("HTTP/1.1 404 Not Found");
            header('Content-type: application/json; charset=UTF-8');

            echo json_encode(['error' => 'Unknown command']);
            exit();
        }
        $user = $ssoServer->$command();
        if($user)
        return response()->json($user);
    }
}

