<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TagsForRaisedby;

class storeNewRaisedBy extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'raisedby_tags' => 'required|string',
        ]);

        $existed_raisedby = TagsForRaisedby::where('raisedby_tags', $request->raisedby_tags)->first();

        if (!$existed_raisedby) {

            $raisedby = new TagsForRaisedby;
            $raisedby->raisedby_tags = $request->raisedby_tags;
            $raisedby->save();
        }
        return redirect('/raisedbycontrol')->with('success', 'Raised By added successfully.');
    }
}
