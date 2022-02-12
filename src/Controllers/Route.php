<?php

namespace Adminro\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Route
{
    protected $controllerSettings;
    protected $route_key;
    protected $route_action;
    protected $redirect_action;
    protected $params = [];
    protected $session_type;
    protected $session_messages;

    const ROUTE_ACTION_MESSAGES = [
        'store' => '{model} is stored successfully: {title}',
        'update' => '{model} is updated successfully: {title}',
        'delete' => '{model} is deleted successfully: {title}',
        'restore' => '{model} is restored successfully: {title}',
        'force_delete' => '{model} is deleted successfully: {title}',
    ];

    const SUBMIT_REDIRECT_ACTION = [
        'continue' => 'edit',
        'add_new' => 'create',
        'exit' => 'index',
    ];

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setRouteKey($route_key)
    {
        $this->route_key = $route_key;
    }

    public function setRouteAction($route_action)
    {
        $this->route_action = $route_action;
    }

    public function setRedirectAction($redirect_action)
    {
        $this->redirect_action = $redirect_action;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function setSessionType($session_type)
    {
        $this->session_type = $session_type;
    }

    public function setSessionMessages($session_messages)
    {
        $this->session_messages = $session_messages;
    }

    public function routeKey()
    {
        return $this->route_key;
    }

    public function routeAction()
    {
        return $this->route_action;
    }

    public function params()
    {
        return $this->params;
    }

    public function redirectAction()
    {
        return $this->redirect_action;
    }

    public function sessionType()
    {
        return $this->session_type;
    }

    public function sessionMessages()
    {
        return $this->session_messages;
    }

    public function redirectRoute()
    {
        return $this->routeKey() . '.' . $this->redirectAction();
    }

    public function setRedirectData()
    {
        $submit = $this->controllerSettings()->request()->requestKey('submit');

        $redirect_action = $this->redirectAction() ?? self::SUBMIT_REDIRECT_ACTION[$submit];
        $this->setRedirectAction($redirect_action);

        if ($redirect_action == 'edit') {
            $this->addParam('id', $this->controllerSettings()->model()->model()['id']);
        }

        if (Arr::has(self::ROUTE_ACTION_MESSAGES, [$this->routeAction()])) {
            $session_message = self::ROUTE_ACTION_MESSAGES[$this->routeAction()];
            $session_message = Str::replace('{model}', $this->controllerSettings()->info()->singularTitle(), $session_message);
            $session_message = Str::replace('{title}', $this->controllerSettings()->model()->model()['title'], $session_message);
            $this->setSessionMessages([$session_message]);
        }
    }
}
