<?php

namespace App\Http\Middleware;

use App\Models\db\Divisi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDivisiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized. Missing token'
            ], 401);
        }

        $token = substr($authorizationHeader, 7); // Remove 'Bearer ' from the token

        $divisi = Divisi::where('token', $token)->first();

        if (!$divisi) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized. Invalid token'
            ], 401);
        }

        // Check if URL is specified and matches the request origin
        if ($divisi->url) {
            $referer = $request->headers->get('referer');
            $origin = parse_url($referer, PHP_URL_HOST);

            if (!$origin || !str_contains($divisi->url, $origin)) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Unauthorized. Invalid origin'
                ], 401);
            }
        }

        return $next($request);
        // return $next($request);
    }
}
