<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Models\users;

class LogResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $path = $request->path();
        $method = '{' .  $request->method() . '} ';
        $data = $request->all();
        $detail = ' | Details: {';
        foreach ($data as $key => $value) {
            if (is_array($value))
                $detail .= $key . ': ' . implode("','",$value) . ',';
            else
                $detail .= $key . ': ' . $value . ',';
        }
        $detail .= ' }';

        Log::info($method . $path .' | ' . USERS::getAcc($request->header('token')) . $detail);
        if ($response instanceof Response) {
            Log::info("Test");
        }

        return $response;
    }
}
