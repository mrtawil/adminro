<?php

namespace Adminro\Controllers;

use Adminro\Constants\Constants;
use Exception;
use Illuminate\Validation\ValidationException;

class Model
{
    protected $controllerSettings;
    protected $class;
    protected $model;

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function class()
    {
        return $this->class;
    }

    public function model()
    {
        return $this->model;
    }

    public function find($id, $with_trashed = false, $findOrFail = true)
    {
        $model = $this->class()::query();
        if ($with_trashed) {
            $model->withTrashed();
        }

        if ($findOrFail) {
            $model = $model->findOrFail($id);
        } else {
            $model = $model->find($id);
        }

        $this->setModel($model);
    }

    public function store()
    {
        try {
            $this->setModel($this->class()::create(filterModelValidated($this->class(), $this->controllerSettings()->request()->validated(), is_post_save: false)));
            postSaveModel($this->model(), filterModelValidated($this->class(), $this->controllerSettings()->request()->validated(), is_post_save: true), $this->controllerSettings()->formFields()->forms(), true, $this->controllerSettings()->info()->storeFolderName());
            $this->model()->save();
            $this->updateSettings(store: true);
            $this->controllerSettings()->route()->setSessionType('success');
        } catch (Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function update()
    {
        try {
            $this->model()->update(filterModelValidated($this->class(), $this->controllerSettings()->request()->validated(), is_post_save: false));
            postSaveModel($this->model(), filterModelValidated($this->class(), $this->controllerSettings()->request()->validated(), is_post_save: true), $this->controllerSettings()->formFields()->forms(), false, $this->controllerSettings()->info()->storeFolderName());
            $this->model()->save();
            $this->updateSettings(remove: true, store: true);
            $this->controllerSettings()->route()->setSessionType('success');
        } catch (Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function destroy()
    {
        try {
            $this->model()->delete();
            $this->model()->update(['status' => Constants::STATUS_DELETED]);
            $this->controllerSettings()->route()->setSessionType('success');
        } catch (Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function restore()
    {
        try {
            $this->model()->restore();
            $this->model()->update(['status' => Constants::STATUS_PUBLISHED]);
            $this->controllerSettings()->route()->setSessionType('success');
        } catch (Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function forceDelete()
    {
        try {
            $this->model()->forceDelete();
            postDeleteModel($this->model(), $this->controllerSettings()->formFields()->forms());
            $this->updateSettings(remove: true);
            $this->controllerSettings()->route()->setSessionType('success');
        } catch (Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function bulkAction()
    {
        $bulk_action = $this->controllerSettings()->request()->validated()['bulk_action'];
        $ids = $this->controllerSettings()->request()->validated()['ids'];

        try {
            $models_query = $this->class()::withTrashed()->whereIn('id', $ids);

            switch ($bulk_action) {
                case 'bulk_delete':
                    $models_query->delete();
                    $models_query->update(['status' => Constants::STATUS_DELETED]);
                    break;

                case 'bulk_restore':
                    $models_query->update(['status' => Constants::STATUS_PUBLISH]);
                    $models_query->restore();
                    break;

                case 'bulk_force_delete':
                    foreach ($models_query->get() as $model) {
                        $this->setModel($model);
                        postDeleteModel($this->model(), $this->controllerSettings()->formFields()->forms());
                        $this->updateSettings(remove: true);
                    }
                    $models_query->forceDelete();
                    break;
            }

            $this->controllerSettings()->route()->setSessionType('success');
        } catch (Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function updateSettings($remove = false, $store = false)
    {
        if (!config('adminro.model_owner_settings_manager')) {
            return;
        }

        try {
            if ($remove) call_user_func([config('adminro.model_owner_settings_manager'), 'removeOwnerSettings'], $this->model());
            if ($store) call_user_func([config('adminro.model_owner_settings_manager'), 'storeOwnerSettings'], $this->model(), $this->controllerSettings()->request()->validated());
        } catch (Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }
}
