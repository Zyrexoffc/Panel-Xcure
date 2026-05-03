<?php

namespace Pterodactyl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Pterodactyl\Models\Server;

class PanelProtectWeb
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $path = $request->path();

        // Skip API requests - those are handled by PanelProtect middleware
        if (str_starts_with($path, 'api/')) {
            return $next($request);
        }

        // Cek jika path mengandung /server/ (client server page)
        if (preg_match('#^server/([^/]+)#', $path, $matches)) {
            $identifier = $matches[1];
            $server = Server::where('uuid', $identifier)
                ->orWhere('uuid_short', $identifier)
                ->first();

            if ($server && $server->protected) {
                // Hanya owner yang boleh akses
                if (!$user || $user->id !== $server->user->id) {
                    return response()->view('protect.warning', [], 403);
                }
            }
        }

        return $next($request);
    }
}
