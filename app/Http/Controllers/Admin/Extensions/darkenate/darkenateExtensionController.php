<?php

namespace Xcure\Http\Controllers\Admin\Extensions\darkenate;

use Illuminate\View\View;
use Illuminate\View\Factory as ViewFactory;
use Xcure\Http\Controllers\Controller;
use Xcure\Services\Helpers\SoftwareVersionService;

use Xcure\BlueprintFramework\Libraries\ExtensionLibrary\Admin\BlueprintAdminLibrary as BlueprintExtensionLibrary;

class darkenateExtensionController extends Controller
{
  /**
   * darkenateExtensionController constructor.
   */
  public function __construct(
    private BlueprintExtensionLibrary $blueprint,
    private SoftwareVersionService $version,
    private ViewFactory $view
  ){}
  
  /**
   * Return the extension index view.
   */
  public function index(): View
  {
    $rootPath = "/admin/extensions/darkenate";
    return $this->view->make('admin.extensions.darkenate.index', [
      'blueprint' => $this->blueprint,
      'version' => $this->version,
      'root' => $rootPath
    ]);
  }
}
