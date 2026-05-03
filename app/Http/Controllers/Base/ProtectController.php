<?php

namespace Xcure\Http\Controllers\Base;

use Illuminate\Http\Request;
use Xcure\Http\Controllers\Controller;

class ProtectController extends Controller
{
    public function index()
    {
        return view('protect.settings');
    }

    public function toggle(Request $request)
    {
        $user = $request->user();
        $user->panel_protect = $request->has('panel_protect');
        $user->save();

        return redirect()->route('protect.settings')->with('success', 'Panel Protect berhasil diupdate.');
    }
}
