<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PasswordResetCheck;
use Illuminate\Support\Facades\Auth;
use App\Models\UserUnauthorizedHistory;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Protect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'You Need to login Again');
        }


        $checkpasswordreset = PasswordResetCheck::where('email', '=', $request->user()->email)->first();


        $user = $request->user();
        $routeName = $request->route()->getName();
        if ($request->user()->status()) {

            if ($routeName != 'reset-password') {
                if (empty($checkpasswordreset)) {
                    return redirect('reset')->with('error', 'You Need to Reset your Password');
                }
            }

            if ($routeName == 'team-manager') {
                if ($request->user()->isteammanager() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'OSS General');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route2') {
                if ($request->user()->route2() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'OSS Details');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route3') {
                if ($request->user()->route3() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'Layer3');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route4') {
                if ($request->user()->route4() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'nlm');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route5') {
                if ($request->user()->route5() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'Layer4');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route6') {
                if ($request->user()->route6() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'Layer5');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route7') {
                if ($request->user()->route7() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'Province');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route8') {
                if ($request->user()->route8() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R1');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route9') {
                if ($request->user()->route9() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R2');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route10') {
                if ($request->user()->route10() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R3');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route11') {
                if ($request->user()->route11() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R4');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route12') {
                if ($request->user()->route12() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R5');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route13') {
                if ($request->user()->route13() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R6');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route14') {
                if ($request->user()->route14() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R7');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route15') {
                if ($request->user()->route15() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R8');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route16') {
                if ($request->user()->route16() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R9');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route17') {
                if ($request->user()->route17() || $request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'R10');
                    abort(403, 'Unauthorized');
                }
            }

            if ($routeName == 'route18') {
                if ($request->user()->route18() || $request->user()->hasProcessLive()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'Processor-Live');
                    abort(403, 'Unauthorized');
                }
            }


            if ($routeName == 'admin') {
                if ($request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'Admin');
                    abort(403, 'Unauthorized');
                }
            }

            if (
                $routeName == 'user-control' ||
                $routeName == 'raisedbytags.store' ||
                $routeName == 'raisedbycontrol' ||
                $routeName == 'raisedbycontrol' ||
                $routeName == 'assign-credentials-controll' ||
                $routeName == 'teams.import' ||
                $routeName == 'batch-interface' ||
                $routeName == 'batchupload' ||
                $routeName == 'downloadbatchtemplate' ||
                $routeName == 'downloadallrunningsubtasks' ||
                $routeName == 'downloadbatchupdatetemplate' ||
                $routeName == 'batchuploadupdate' ||
                $routeName == 'batchuploadcomplete'  ||
                $routeName == 'downloadbatchcompletetemplate'

            ) {
                if ($request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'User Control');
                    abort(403, 'Unauthorized');
                }
            }

            if (
                $routeName == 'welcome' ||
                $routeName == 'reset-password' ||
                $routeName == 'tasksoverview' ||
                $routeName == 'usertasksoverview' ||
                $routeName == 'tasks' ||

                $routeName == 'dispatchedbyme' ||
                $routeName == 'mytasks' ||
                $routeName == 'cancelled' ||
                $routeName == 'controltask' ||
                $routeName == 'completed' ||
                $routeName == 'support'
            ) {
                return $next($request);
            }

            if ($routeName == 'users.store') {
                if ($request->user()->isSuperUser()) {
                    return $next($request);
                } else {
                    UserUnauthorizedHistory::logUserUnauthorizedHistory($user, $request->ip(), Session::getId(), 'Store User');
                    abort(403, 'Unauthorized');
                }
            }
        } else {
            $request->user()->logout;
            return redirect('/')->with('error', 'Your Account is Disabled');
        }
    }
}
