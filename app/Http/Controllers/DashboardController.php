<?php

namespace App\Http\Controllers;

use App\Models\Events;

class DashboardController extends Controller
{
    protected $title = 'Dashboard';
    protected $breadcrumb = [['url' => '/dashboard', 'title' => 'Dashboard']];

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $events = Events::paginate(24);
        return $this->render('dashboard', [
            'events' => $events,
            'menus' => $this->getMenus(),
        ]);
    }
}