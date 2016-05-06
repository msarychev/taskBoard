<?php

namespace App\Http\Controllers;

use App\Models\Worker;

class HomeController extends Controller
{

    public function index($workerId = null)
    {

        $workers = Worker::all()->sortBy('name');

        $arWorkers = [];
        foreach ($workers as $worker) :
            $arWorkers[$worker->id] = $worker->name;
        endforeach;

        if ($workerId) {
            $displayWorkers[] = Worker::findOrFail($workerId);
        } else {
            $displayWorkers = $workers;
        }

        return view('table')->with(['workers' => $displayWorkers, 'arWorkers' => $arWorkers]);
    }
}
