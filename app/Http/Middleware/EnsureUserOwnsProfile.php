<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserOwnsProfile
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user(); // جلب المستخدم المتصل
        $profileUserId = $request->route('user')->id; // جلب الـ id من الـ User object

        // تحقق من أن المستخدم المتصل يملك الملف الشخصي الذي يحاول الوصول إليه
        if ($user->id !== $profileUserId) {
            return redirect('/home')->with('error', 'Unauthorized access to profile.');
        }

        return $next($request); // السماح بمتابعة الطلب إذا كان التحقق ناجحاً
    }
}
