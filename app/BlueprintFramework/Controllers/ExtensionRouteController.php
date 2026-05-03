<?php

namespace Xcure\BlueprintFramework\Controllers;

use Xcure\Http\Requests\Api\Client\ClientApiRequest;
use Xcure\Http\Controllers\Api\Client\ClientApiController;
use Xcure\Contracts\Repository\SettingsRepositoryInterface;

class ExtensionRouteController extends ClientApiController
{
    public function __construct(
        private SettingsRepositoryInterface $settings,
    ) {
        parent::__construct();
    }

    public function eggs(GetRouteEggsRequest $request): array
    {
        $id = $request->input('id', 'blueprint');
        $eggs = $this->settings->get('blueprint::extensionconfig_' . $id . '_eggs');
        return json_decode($eggs ?: '["-1"]');
    }
}

class GetRouteEggsRequest extends ClientApiRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
