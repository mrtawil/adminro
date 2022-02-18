<?php

namespace Adminro\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Authentication
{
    protected $controllerSettings;
    protected $required;
    protected $user;

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setRequired($required)
    {
        $this->required = $required;
    }

    public function setAuth()
    {
        $this->setUser();
    }

    public function setUser()
    {
        $this->user = Auth::user();
    }

    public function required()
    {
        return $this->required;
    }

    public function user()
    {
        if ($this->required() && !$this->user) {
            abort(409, 'Please set auth.');
        }

        return $this->user;
    }

    public function authorize($action = '')
    {
        $abilites = collect();
        if (is_array($action)) {
            foreach ($action as $action_rec) {
                $abilites->push($this->controllerSettings()->info()->key() . ' ' . $action_rec);
            }
        } else {
            $abilites->push($this->controllerSettings()->info()->key() . ' ' . $action);
        }

        Gate::allowIf($this->user()->canAny($abilites));
    }
}
