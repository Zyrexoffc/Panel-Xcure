<?php

namespace Xcure\Http\Controllers\Admin\Nests;

use Xcure\Models\Egg;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Xcure\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Xcure\Services\Eggs\Sharing\EggExporterService;
use Xcure\Services\Eggs\Sharing\EggImporterService;
use Xcure\Http\Requests\Admin\Egg\EggImportFormRequest;
use Xcure\Services\Eggs\Sharing\EggUpdateImporterService;

class EggShareController extends Controller
{
    /**
     * EggShareController constructor.
     */
    public function __construct(
        protected AlertsMessageBag $alert,
        protected EggExporterService $exporterService,
        protected EggImporterService $importerService,
        protected EggUpdateImporterService $updateImporterService,
    ) {
    }

    /**
     * @throws \Xcure\Exceptions\Repository\RecordNotFoundException
     */
    public function export(Egg $egg): Response
    {
        $filename = trim(preg_replace('/\W/', '-', kebab_case($egg->name)), '-');

        return response($this->exporterService->handle($egg->id), 200, [
            'Content-Transfer-Encoding' => 'binary',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename=egg-' . $filename . '.json',
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Import a new service option using an XML file.
     *
     * @throws \Xcure\Exceptions\Model\DataValidationException
     * @throws \Xcure\Exceptions\Repository\RecordNotFoundException
     * @throws \Xcure\Exceptions\Service\Egg\BadJsonFormatException
     * @throws \Xcure\Exceptions\Service\InvalidFileUploadException
     */
    public function import(EggImportFormRequest $request): RedirectResponse
    {
        $egg = $this->importerService->handle($request->file('import_file'), $request->input('import_to_nest'));
        $this->alert->success(trans('admin/nests.eggs.notices.imported'))->flash();

        return redirect()->route('admin.nests.egg.view', ['egg' => $egg->id]);
    }

    /**
     * Update an existing Egg using a new imported file.
     *
     * @throws \Xcure\Exceptions\Model\DataValidationException
     * @throws \Xcure\Exceptions\Repository\RecordNotFoundException
     * @throws \Xcure\Exceptions\Service\Egg\BadJsonFormatException
     * @throws \Xcure\Exceptions\Service\InvalidFileUploadException
     */
    public function update(EggImportFormRequest $request, Egg $egg): RedirectResponse
    {
        $this->updateImporterService->handle($egg, $request->file('import_file'));
        $this->alert->success(trans('admin/nests.eggs.notices.updated_via_import'))->flash();

        return redirect()->route('admin.nests.egg.view', ['egg' => $egg]);
    }
}
