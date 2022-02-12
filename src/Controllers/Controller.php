<?php

namespace Adminro\Controllers;

use Adminro\Controllers\ControllerSettings;
use Adminro\Requests\BulkActionRequest;
use Adminro\Traits\Controller as TraitsController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, TraitsController;

    protected $controllerSettings;
    protected $key;
    protected $route_key;
    protected $singular_title;
    protected $model;
    protected $dataTable_class;
    protected $validation_rules_store = [];
    protected $validation_rules_update = [];
    protected $validation_classes_store = [];
    protected $validation_classes_update = [];
    protected $subheader_show = true;
    protected $subheader_back = true;
    protected $action_create = true;
    protected $action_edit = true;
    protected $action_update = true;
    protected $action_delete = true;
    protected $action_show = false;
    protected $action_print = false;
    protected $action_restore = true;
    protected $action_search = true;
    protected $action_reset = true;
    protected $action_buttons = true;
    protected $bulk_action = true;
    protected $create_script_files = [];
    protected $edit_script_files = [];

    public function __construct()
    {
        if (!$this->route_key) {
            $this->route_key = Str::plural($this->key);
        }

        if (!$this->singular_title) {
            $this->singular_title = $this->key;
        }

        $this->controllerSettings = new ControllerSettings();
        $this->controllerSettings->auth()->setRequired(true);
        $this->controllerSettings->route()->setRouteKey($this->route_key);
        $this->controllerSettings->info()->setKey($this->key);
        $this->controllerSettings->info()->setBackUrl(route('dashboard.index'));
        $this->controllerSettings->info()->setSingularTitle($this->singular_title);
        $this->controllerSettings->info()->setPluralTitle(Str::plural($this->singular_title));
        $this->controllerSettings->subheader()->setShow($this->subheader_show);
        $this->controllerSettings->subheader()->setBack($this->subheader_back);
        $this->controllerSettings->actions()->setCreate($this->action_create);
        $this->controllerSettings->actions()->setEdit($this->action_edit);
        $this->controllerSettings->actions()->setUpdate($this->action_update);
        $this->controllerSettings->actions()->setDelete($this->action_delete);
        $this->controllerSettings->actions()->setShow($this->action_show);
        $this->controllerSettings->actions()->setPrint($this->action_print);
        $this->controllerSettings->actions()->setRestore($this->action_restore);
        $this->controllerSettings->actions()->setSearch($this->action_search);
        $this->controllerSettings->actions()->setReset($this->action_reset);
        $this->controllerSettings->actions()->setButtons($this->action_buttons);
        $this->controllerSettings->actions()->setBulkAction($this->bulk_action);

        if ($this->model) {
            $this->controllerSettings->info()->setStoreFolderName($this->model::STORE_FOLDER_NAME);
            $this->controllerSettings->model()->setClass($this->model);
            $this->controllerSettings->formFields()->setForms($this->model::formFields());
        }

        if (Route::has($this->route_key . '.index')) $this->controllerSettings->info()->setActiveRoute($this->route_key . '.index');
        if (Route::has($this->route_key . '.create')) $this->controllerSettings->info()->setCreateUrl(route($this->route_key . '.create'));
        if (Route::has($this->route_key . '.store')) $this->controllerSettings->info()->setStoreUrl(route($this->route_key . '.store'));
        if (Route::has($this->route_key . '.edit')) $this->controllerSettings->info()->setEditUrl(route($this->route_key . '.edit', ['id' => ':id']));
        if (Route::has($this->route_key . '.update')) $this->controllerSettings->info()->setUpdateUrl(route($this->route_key . '.update', ['id' => ':id']));
        if (Route::has($this->route_key . '.delete')) $this->controllerSettings->info()->setDeleteUrl(route($this->route_key . '.delete', ['id' => ':id']));
        if (Route::has($this->route_key . '.restore')) $this->controllerSettings->info()->setRestoreUrl(route($this->route_key . '.restore', ['id' => ':id']));
        if (Route::has($this->route_key . '.force_delete')) $this->controllerSettings->info()->setForceDeleteUrl(route($this->route_key . '.force_delete', ['id' => ':id']));
        if (Route::has($this->route_key . '.bulk_action')) $this->controllerSettings->info()->setBulkActionUrl(route($this->route_key . '.bulk_action'));

        $this->addOnConstruct();
    }

    public function index(Request $request)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'browse');
        $this->controllerSettings->route()->setRouteAction('index');
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->info()->setPageTitle($this->controllerSettings->info()->pluralTitle() . ' List');
        $this->controllerSettings->info()->setBackUrl(route('dashboard.index'));
        $this->controllerSettings->dataTable()->initDataTable($this->dataTable_class);
        $this->addOnAll();
        $this->addOnIndex();

        if ($this->controllerSettings->dataTable()->dataTable()) {
            return $this->controllerSettings->dataTable()->dataTable()->render('adminro::pages.dashboard.utils.index', ['controllerSettings' => $this->controllerSettings, 'dataTable' => $this->controllerSettings->dataTable()->dataTable()]);
        }

        return view('adminro::pages.dashboard.utils.index', ['controllerSettings' => $this->controllerSettings]);
    }

    public function create(Request $request)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'add');
        $this->controllerSettings->route()->setRouteAction('create');
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->info()->setPageTitle('Add ' . $this->controllerSettings->info()->singularTitle());
        $this->controllerSettings->info()->setBackUrl(route($this->controllerSettings->route()->routeKey() . '.index'));
        $this->controllerSettings->info()->setScriptFiles($this->create_script_files);
        $this->controllerSettings->subheader()->setDescription('Enter ' . $this->controllerSettings->info()->singularTitle(uppercase: false) . ' details and save');
        $this->controllerSettings->subheader()->setAction(true);
        $this->controllerSettings->subheader()->setActionCreate(true);
        $this->controllerSettings->subheader()->setActionUpdate(true);
        $this->controllerSettings->subheader()->setActionExit(true);
        $this->controllerSettings->formFields()->addSelect('status', call_user_func([config('adminro.select_manager'), 'getPublishSelect'], 1));
        $this->addOnAll();
        $this->addOnCreate();

        if ($this->controllerSettings->dataTable()->dataTable()) {
            return $this->controllerSettings->dataTable()->dataTable()->render('adminro::pages.dashboard.utils.create', ['controllerSettings' => $this->controllerSettings, 'dataTable' => $this->controllerSettings->dataTable()->dataTable()]);
        }

        return view('adminro::pages.dashboard.utils.create', ['controllerSettings' => $this->controllerSettings]);
    }

    public function store(Request $request)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'add');
        $this->controllerSettings->route()->setRouteAction('store');
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->request()->setRules($this->validation_rules_store);
        $this->controllerSettings->request()->addFormFieldsRules();
        $this->controllerSettings->request()->validate();
        $this->controllerSettings->request()->addCreatorKeys();
        $this->controllerSettings->request()->setValidationClasses($this->validation_classes_store);
        $this->controllerSettings->request()->validateClasses();
        $this->controllerSettings->formFields()->customizeValidated();
        $this->controllerSettings->model()->store();
        $this->controllerSettings->route()->setRedirectData();
        $this->addOnAll();
        $this->addOnStore();

        return redirect()->route($this->controllerSettings->route()->redirectRoute(), $this->controllerSettings->route()->params())->with($this->controllerSettings->route()->sessionType(), $this->controllerSettings->route()->sessionMessages());
    }

    public function edit(Request $request, $id)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'edit');
        $this->controllerSettings->model()->find($id, false);
        $this->controllerSettings->route()->addParam('id', $id);
        $this->controllerSettings->route()->setRouteAction('edit');
        $this->controllerSettings->info()->setPageTitle('Edit ' . $this->controllerSettings->info()->singularTitle());
        $this->controllerSettings->info()->setBackUrl(route($this->controllerSettings->route()->routeKey() . '.index'));
        if (Route::has($this->route_key . '.remove_file')) $this->controllerSettings->info()->setRemoveFileUrl(route($this->route_key . '.remove_file', ['id' => $id, 'attribute' => ':attribute']));
        $this->controllerSettings->info()->setScriptFiles($this->edit_script_files);
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->request()->setEditMode(true);
        $this->controllerSettings->subheader()->setDescription('Enter ' . $this->controllerSettings->info()->singularTitle(uppercase: false) . ' details and save');
        $this->controllerSettings->subheader()->setAction(true);
        $this->controllerSettings->subheader()->setActionCreate(true);
        $this->controllerSettings->subheader()->setActionUpdate(true);
        $this->controllerSettings->subheader()->setActionDelete(true);
        $this->controllerSettings->subheader()->setActionExit(true);
        $this->controllerSettings->formFields()->addSelect('status', call_user_func([config('adminro.select_manager'), 'getPublishSelect'], $this->controllerSettings->model()->model()->status));
        $this->addOnAll();
        $this->addOnEdit();

        if ($this->controllerSettings->dataTable()->dataTable()) {
            return $this->controllerSettings->dataTable()->dataTable()->render('adminro::pages.dashboard.utils.edit', ['controllerSettings' => $this->controllerSettings, 'dataTable' => $this->controllerSettings->dataTable()->dataTable()]);
        }

        return view('adminro::pages.dashboard.utils.edit', ['controllerSettings' => $this->controllerSettings]);
    }

    public function update(Request $request, $id)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'edit');
        $this->controllerSettings->model()->find($id, false);
        $this->controllerSettings->route()->setRouteAction('update');
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->request()->setEditMode(true);
        $this->controllerSettings->request()->setRules($this->validation_rules_update);
        $this->controllerSettings->request()->addFormFieldsRules();
        $this->controllerSettings->request()->validate();
        $this->controllerSettings->request()->setValidationClasses($this->validation_classes_update);
        $this->controllerSettings->request()->validateClasses();
        $this->controllerSettings->formFields()->customizeValidated();
        $this->controllerSettings->model()->update();
        $this->controllerSettings->route()->setRedirectData();
        $this->addOnAll();
        $this->addOnUpdate();

        return redirect()->route($this->controllerSettings->route()->redirectRoute(), $this->controllerSettings->route()->params())->with($this->controllerSettings->route()->sessionType(), $this->controllerSettings->route()->sessionMessages());
    }

    public function delete(Request $request, $id)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'delete');
        $this->controllerSettings->model()->find($id, false);
        $this->controllerSettings->route()->setRouteAction('delete');
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->model()->delete();
        $this->controllerSettings->route()->setRedirectAction('index');
        $this->controllerSettings->route()->setRedirectData();
        $this->addOnAll();
        $this->addOnDelete();

        return redirect()->route($this->controllerSettings->route()->redirectRoute(), $this->controllerSettings->route()->params())->with($this->controllerSettings->route()->sessionType(), $this->controllerSettings->route()->sessionMessages());
    }

    public function restore(Request $request, $id)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'restore');
        $this->controllerSettings->model()->find($id, true);
        $this->controllerSettings->route()->setRouteAction('restore');
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->model()->restore();
        $this->controllerSettings->route()->setRedirectAction('index');
        $this->controllerSettings->route()->setRedirectData();
        $this->addOnAll();
        $this->addOnRestore();

        return redirect()->route($this->controllerSettings->route()->redirectRoute(), $this->controllerSettings->route()->params())->with($this->controllerSettings->route()->sessionType(), $this->controllerSettings->route()->sessionMessages());
    }

    public function forceDelete(Request $request, $id)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'delete');
        $this->controllerSettings->model()->find($id, true);
        $this->controllerSettings->route()->setRouteAction('force_delete');
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->model()->forceDelete();
        $this->controllerSettings->route()->setRedirectAction('index');
        $this->controllerSettings->route()->setRedirectData();
        $this->addOnAll();
        $this->addOnForceDelete();

        return redirect()->route($this->controllerSettings->route()->redirectRoute(), $this->controllerSettings->route()->params())->with($this->controllerSettings->route()->sessionType(), $this->controllerSettings->route()->sessionMessages());
    }

    public function removeFile(Request $request, $id, $attribute)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'edit');
        $this->controllerSettings->model()->find($id, true);
        $this->controllerSettings->route()->setRouteAction('delete');
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->model()->removeFile($attribute);
        $this->controllerSettings->route()->setRedirectAction('edit');
        $this->controllerSettings->route()->setRedirectData();
        $this->addOnAll();
        $this->addOnRemoveFile($attribute);

        return redirect()->route($this->controllerSettings->route()->redirectRoute(), $this->controllerSettings->route()->params())->with($this->controllerSettings->route()->sessionType(), $this->controllerSettings->route()->sessionMessages());
    }

    public function bulkAction(BulkActionRequest $request)
    {
        $this->controllerSettings->auth()->setAuth();
        $this->controllerSettings->auth()->authorize(action: 'bulk action');
        $this->controllerSettings->route()->setRouteAction('bulk_action');
        $this->controllerSettings->request()->setRequest($request);
        $this->controllerSettings->request()->setValidated($request->validated());
        $this->controllerSettings->model()->bulkAction();
        $this->controllerSettings->route()->setRedirectAction('index');
        $this->controllerSettings->route()->setRedirectData();
        $this->addOnAll();
        $this->addOnBulkAction();

        return redirect()->route($this->controllerSettings->route()->redirectRoute(), $this->controllerSettings->route()->params())->with($this->controllerSettings->route()->sessionType(), $this->controllerSettings->route()->sessionMessages());
    }
}
