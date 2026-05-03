<?php

namespace Pterodactyl\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Models\Server;

class PanelProtectController extends Controller
{
    public function index(Request $request, string $serverIdentifier): array
    {
        $server = Server::where('uuid', $serverIdentifier)
            ->orWhere('uuid_short', $serverIdentifier)
            ->firstOrFail();
        
        if ($request->user()->id !== $server->user->id) {
            abort(403, 'Unauthorized');
        }
        
        return [
            'protected' => $server->protected,
        ];
    }
    
    public function toggle(Request $request, string $serverIdentifier): JsonResponse
    {
        $server = Server::where('uuid', $serverIdentifier)
            ->orWhere('uuid_short', $serverIdentifier)
            ->firstOrFail();
        
        if ($request->user()->id !== $server->user->id) {
            abort(403, 'Unauthorized');
        }
        
        $server->protected = !$server->protected;
        $server->save();
        
        return new JsonResponse([
            'protected' => $server->protected,
            'message' => 'Server Protect ' . ($server->protected ? 'enabled' : 'disabled'),
        ]);
    }
}
