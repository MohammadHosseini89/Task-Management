<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;

class HubComponent extends Component
{
    public function render(Request $request)
    {

        $member_since = $request->user()->created_at->format('M. Y');
        $status_user = $request->user()->status;
        $user_name = $request->user()->name;
        if ($request->user()->status === 'disabled') {
            $access_count = 0;
        } elseif ($request->user()->is_superuser) {
            $access_count = 19;
        } else {
            $access_count = $request->user()->route1 + $request->user()->route2
                + $request->user()->route3 + $request->user()->route4
                + $request->user()->route5 + $request->user()->route6
                + $request->user()->route7 + $request->user()->route8
                + $request->user()->route9 + $request->user()->route10
                + $request->user()->route11 + $request->user()->route12
                + $request->user()->route13 + $request->user()->route14
                + $request->user()->route15 + $request->user()->route16
                + $request->user()->route17 + $request->user()->route18;
        }

        $user_found = User::find($request->user()->id);
        $loginHistoryCount = $user_found->loginHistories()->count();
        $lastTwoLoginHistories = $user_found->loginHistories()->latest('login_time')->limit(2)->get();

        return view('livewire.hub-component', [
            'member_since' => $member_since,
            'status_user' => $status_user,
            'access_count' => $access_count,
            'user_name' => $user_name,
            'loginHistoryCount' => $loginHistoryCount,
            'lastTwoLoginHistories' => $lastTwoLoginHistories,

        ]);
    }
}
