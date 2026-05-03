<?php

namespace Pterodactyl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Pterodactyl\Models\Server;

class PanelProtect
{
    public function handle(Request $request, Closure $next)
    {
        $authUser = $request->user();
        $server = $this->resolveServer($request);
        
        // Debug log
        $log = sprintf(
            "[%s] path=%s server=%s protected=%s owner_protect=%s auth_id=%s\n",
            date('Y-m-d H:i:s'),
            $request->path(),
            $server ? $server->id : 'null',
            $server ? $server->protected : 'null',
            $server && $server->user ? $server->user->panel_protect : 'null',
            $authUser ? $authUser->id : 'null'
        );
        file_put_contents('/tmp/protect_debug.log', $log, FILE_APPEND);
        
        if (!$server) {
            return $next($request);
        }
        
        // Check if server is protected (per-server) OR owner has panel_protect enabled
        $owner = $server->user;
        $isProtected = $server->protected || ($owner && $owner->panel_protect);
        
        $log2 = sprintf(
            "[%s] isProtected=%s owner_id=%s\n",
            date('Y-m-d H:i:s'),
            $isProtected ? 'true' : 'false',
            $owner ? $owner->id : 'null'
        );
        file_put_contents('/tmp/protect_debug.log', $log2, FILE_APPEND);
        
        if ($isProtected) {
            // Only allow if the authenticated user is the owner
            if (!$authUser || $authUser->id !== $owner->id) {
                $log3 = sprintf("[%s] DENIED access to server %s\n", date('Y-m-d H:i:s'), $server->id);
                file_put_contents('/tmp/protect_debug.log', $log3, FILE_APPEND);
                return $this->deny($request);
            }
        }
        
        return $next($request);
    }
    
    protected function resolveServer(Request $request): ?Server
    {
        $route = $request->route();
        
        // Try route parameters first
        if ($route) {
            // Check 'server' parameter (API/admin routes)
            $param = $route->parameter('server');
            if ($param instanceof Server) {
                return $param;
            }
            
            // Check 'identifier' parameter (web /server/{identifier} route)
            $param = $route->parameter('identifier');
            if (is_string($param)) {
                $server = Server::where('uuid', $param)
                    ->orWhere('uuid_short', $param)
                    ->first();
                if ($server) {
                    return $server;
                }
            }
            
            if (is_string($param = $route->parameter('server'))) {
                $server = Server::where('uuid', $param)
                    ->orWhere('uuid_short', $param)
                    ->first();
                if ($server) {
                    return $server;
                }
            }
        }
        
        // Fallback: parse request path to find server UUID
        $path = $request->path();
        if (preg_match('#(?:/servers|/server)/([a-zA-Z0-9]{8,})#', $path, $matches)) {
            $identifier = $matches[1];
            return Server::where('uuid', $identifier)
                ->orWhere('uuid_short', $identifier)
                ->first();
        }
        
        return null;
    }
    
    protected function deny(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Forbidden',
                'message' => 'Server protected'
            ], 403);
        }
        return response()->view('protect.warning', [], 403);
    }
}
