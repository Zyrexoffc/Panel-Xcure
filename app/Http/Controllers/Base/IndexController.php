<?php

namespace Xcure\Http\Controllers\Base;

use Illuminate\View\View;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use Xcure\Http\Controllers\Controller;
use Xcure\Contracts\Repository\ServerRepositoryInterface;
use Xcure\Models\Server;

class IndexController extends Controller
{
    /**
     * IndexController constructor.
     */
    public function __construct(
        protected ServerRepositoryInterface $repository,
        protected ViewFactory $view,
    ) {
    }

    /**
     * Returns listing of user's servers.
     */
    public function index(Request $request): View
    {
        $path = $request->path();
        
        // Check if accessing a server page - call server method directly
        if (preg_match('#^server/([^/]+)#', $path, $matches)) {
            $identifier = $matches[1];
            return $this->server($request, $identifier);
        }
        
        return view('templates/base.core');
    }

    /**
     * Handle server page access with protect check
     */
    public function server(Request $request, string $identifier): View
    {
        $user = $request->user();
        
        // Try to find server by uuid or uuid_short
        $server = \Xcure\Models\Server::where('uuid', $identifier)->first();
        if (!$server) {
            $server = \Xcure\Models\Server::where('uuid_short', $identifier)->first();
        }

        // If server not found, return SPA (let it handle 404)
        if (!$server) {
            return view('templates/base.core');
        }

        // If server is protected and user is not the owner, show warning
        if ($server->protected) {
            if (!$user || $user->id !== $server->user->id) {
                return response()->view('protect.warning', [], 403);
            }
        }

        return view('templates/base.core');
    }
}
