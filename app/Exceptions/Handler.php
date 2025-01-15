<?php

namespace App\Exceptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $levels = [
        //
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (CustomException $e) {
            Log::error('Custom Exception: ' . $e->getMessage(), [
                'error_code' => $e->errorCode,
                'status_code' => $e->statusCode,
            ]);
        });

        // Xử lý CustomException khi xảy ra
        $this->renderable(function (CustomException $e, Request $request) {
            // Nếu đây là API request (mong đợi JSON)
            if ($request->expectsJson()) {
                return $e->render($request);
            }

            // Xử lý nếu là request từ web (không phải API), ví dụ trả về trang lỗi tùy chỉnh
            return response()->view('errors.custom', ['message' => $e->getMessage()]);
        });
    }
}
