<?php

namespace Pterodactyl\Http\Controllers\Base;

use Illuminate\Http\Request;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Models\Server;

class ServerProtectController extends Controller
{
    public function index(Request $request, string $identifier)
    {
        $server = Server::where('uuid', $identifier)
            ->orWhere('uuid_short', $identifier)
            ->firstOrFail();
        
        if ($request->user()->id !== $server->user->id) {
            abort(403);
        }
        
        return view('protect.server-settings', ['server' => $server]);
    }
    
    public function toggle(Request $request, string $identifier)
    {
        $server = Server::where('uuid', $identifier)
            ->orWhere('uuid_short', $identifier)
            ->firstOrFail();
        
        if ($request->user()->id !== $server->user->id) {
            abort(403);
        }
        
        $server->protected = $request->has('protected');
        $server->save();
        
        return redirect()->route('server.protect.settings', ['identifier' => $identifier])
            ->with('success', 'Server Protect berhasil diupdate.');
    }
}
