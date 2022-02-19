<?php

namespace Adminro\Controllers;

use Illuminate\Support\Str;

class Info
{
    protected $controllerSettings;
    protected $key;
    protected $store_folder_name;
    protected $active_route;
    protected $back_url;
    protected $create_url;
    protected $store_url;
    protected $edit_url;
    protected $update_url;
    protected $destroy_url;
    protected $restore_url;
    protected $force_delete_url;
    protected $bulk_action_url;
    protected $singular_title;
    protected $plural_title;
    protected $page_title;
    protected $project_details;
    protected $card_toolbar;
    protected $script_files = [];

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function setStoreFolderName($store_folder_name)
    {
        $this->store_folder_name = $store_folder_name;
    }

    public function setActiveRoute($active_route)
    {
        $this->active_route = $active_route;
    }

    public function setBackUrl($back_url)
    {
        $this->back_url = $back_url;
    }

    public function setCreateUrl($create_url)
    {
        $this->create_url = $create_url;
    }

    public function setStoreUrl($store_url)
    {
        $this->store_url = $store_url;
    }

    public function setEditUrl($edit_url)
    {
        $this->edit_url = $edit_url;
    }

    public function setUpdateUrl($update_url)
    {
        $this->update_url = $update_url;
    }

    public function setDestroyUrl($destroy_url)
    {
        $this->destroy_url = $destroy_url;
    }

    public function setRestoreUrl($restore_url)
    {
        $this->restore_url = $restore_url;
    }

    public function setForceDeleteUrl($force_delete_url)
    {
        $this->force_delete_url = $force_delete_url;
    }

    public function setBulkActionUrl($bulk_action_url)
    {
        $this->bulk_action_url = $bulk_action_url;
    }

    public function setSingularTitle($singular_title = '')
    {
        $this->singular_title = $singular_title;
    }

    public function setPluralTitle($plural_title = '')
    {
        $this->plural_title = $plural_title;
    }

    public function setPageTitle($page_title = '')
    {
        $this->page_title = $page_title;
    }

    public function setProjectDetails($project_details)
    {
        $this->project_details = $project_details;
    }

    public function setCardToolbar($card_toolbar)
    {
        $this->card_toolbar = $card_toolbar;
    }

    public function setScriptFiles($script_file)
    {
        $this->script_files = $script_file;
    }

    public function addScriptFile($script_file)
    {
        array_push($this->script_files, $script_file);
    }

    public function key()
    {
        return $this->key;
    }

    public function storeFolderName()
    {
        return $this->store_folder_name;
    }

    public function activeRoute()
    {
        return $this->active_route;
    }

    public function backUrl()
    {
        return $this->back_url;
    }

    public function createUrl()
    {
        return $this->create_url;
    }

    public function storeUrl()
    {
        return $this->store_url;
    }

    public function editUrl()
    {
        return $this->edit_url;
    }

    public function updateUrl()
    {
        return $this->update_url;
    }

    public function destroyUrl()
    {
        return $this->destroy_url;
    }

    public function restoreUrl()
    {
        return $this->restore_url;
    }

    public function forceDeleteUrl()
    {
        return $this->force_delete_url;
    }

    public function bulkActionUrl()
    {
        return $this->bulk_action_url;
    }

    public function singularTitle($uppercase = true)
    {
        if ($uppercase) {
            return Str::ucfirst($this->singular_title);
        }

        return $this->singular_title;
    }

    public function pluralTitle($uppercase = true)
    {
        if ($uppercase) {
            return Str::ucfirst($this->plural_title);
        }

        return $this->plural_title;
    }

    public function pageTitle($prefix = '', $suffix = '')
    {
        if ($this->page_title) {
            return $this->page_title;
        }

        $output = $this->pluralTitle();
        if ($prefix) $output = $prefix . $output;
        if ($suffix) $output = $output . $suffix;
        return $output;
    }

    public function projectDetails()
    {
        return $this->project_details;
    }

    public function cardToolbar()
    {
        return $this->card_toolbar;
    }

    public function scriptFiles()
    {
        return $this->script_files;
    }
}
