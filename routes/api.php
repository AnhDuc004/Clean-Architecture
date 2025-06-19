<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Interfaces\Http\Controllers\AuthController;
use App\Interfaces\Http\Controllers\Post\PostController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// --------------------
//  Public routes
// --------------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/posts', [PostController::class, 'index']); // Xem danh sách bài viết public

// --------------------
//  Routes cần auth
// --------------------
Route::middleware('auth:sanctum')->group(function () {

    // Lấy thông tin người dùng
    Route::get('/user', fn(Request $request) => $request->user());

    //  Refresh token
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);

    //  Gửi lại email xác thực
    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email đã xác thực rồi']);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Đã gửi lại email xác thực']);
    })->name('verification.send');

    //  Xác thực email khi bấm vào link gửi về email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['message' => 'Email đã được xác thực']);
    })->middleware(['signed'])->name('verification.verify');

    //  Xem chi tiết bài viết (không cần verified)
    Route::get('/posts/{id}', [PostController::class, 'show']);

    // --------------------
    //  Routes cần verified email
    // --------------------
    Route::middleware('verified')->group(function () {
        Route::get('/profile', fn(Request $request) => $request->user());

        Route::post('/posts', [PostController::class, 'store']);
        Route::put('/posts/{id}', [PostController::class, 'update']);
        Route::delete('/posts/{id}', [PostController::class, 'destroy']);
        Route::post('/posts/{id}/like-toggle', [PostController::class, 'toggleLike']);
    });
});
