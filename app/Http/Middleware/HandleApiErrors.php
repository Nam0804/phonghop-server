<?php
namespace App\Http\Middleware;

use Closure;
use App\Exceptions\ApiException;
use Illuminate\Http\JsonResponse;

class HandleApiErrors
{
    public function handle($request, Closure $next)
    {
        try {
            // Tiến hành xử lý request
            return $next($request);
        } catch (ApiException $e) {
            // Xử lý lỗi và trả về response JSON
            return response()->json([
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ],
            ], $e->getCode());
        }
    }
}
// fhgit