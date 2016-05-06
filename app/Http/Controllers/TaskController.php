<?php namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tasks = Task::all();

        return view('task.all')->with(['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $workers = Worker::all();

        $arWorkers = [];

        foreach ($workers as $worker) :
            $arWorkers[$worker->id] = $worker->name;
        endforeach;

        return view('task.create')->with(['workers' => $arWorkers]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'worker_id' => 'required',
            'name' => 'required',
            'time' => 'integer'
        ]);

        if ($request->ajax()) {
            $input = $request->all();
            $newTask = Task::create($input);
            return response()->json(['id' => $newTask->id, 'name' => $newTask->name, 'description' => $newTask->description, 'time' => $newTask->time]);
        }

        $input = $request->all();
        Task::create($input);

        Session::flash('flash_message', 'Task successfully added! <a href="' . route('tasks') . '">Go back to all tasks.</a>');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        $workers = Worker::all();

        $arWorkers = [];

        foreach ($workers as $worker) :
            $arWorkers[$worker->id] = $worker->name;
        endforeach;

        return view('task.edit')->with(['task' => $task, 'workers' => $arWorkers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $task = Task::findOrFail($id);
        
        if ($request->ajax()) {
            $isForm = $request->get('form');
            if ($isForm) {
                $this->validate($request, [
                    'worker_id' => 'required',
                    'name' => 'required',
                    'time' => 'integer'
                ]);
                $input = $request->all();
                $task->fill($input)->save();
                return response()->json(['id' => $task->id, 'name' => $task->name, 'description' => $task->description, 'time' => $task->time]);
            }
            $input = $request->all();
            d($input);
            $task->fill($input)->save();
            return 2;
        }

        $input = $request->all();

        $task->fill($input)->save();

        Session::flash('flash_message', 'Task successfully updated!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $task = Task::findOrFail($id);

        if ($request->ajax()) {
            $task->delete();
            return 1;
        }
        $task->delete();

        Session::flash('flash_message', 'Task successfully deleted!');

        return redirect()->route('tasks');
    }
}
