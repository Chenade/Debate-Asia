<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Models\Users;

class LogResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $path = $request->path();
        $method = '{' .  $request->method() . '} ';
        $data = $request->all();
        if (array_key_exists('dataURI', $data)) $data['dataURI'] = "data/image";
        $detail = ' | Details: {';
        $detail .= json_encode($data, JSON_UNESCAPED_UNICODE);
        $detail .= ' }';

        Log::info($method . $path .' | ' . USERS::getAcc($request->header('token')) . $detail);
        if ($response instanceof Response) {
            Log::info("Test");
        }

        return $response;
    }
}
