<?php namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WorkerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $workers = Worker::all()->sortBy('name');

        return view('worker.all')->with(['workers' => $workers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('worker.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:workers'
        ]);

        if ($request->ajax()) {
            $input = $request->all();
            $worker = Worker::create($input);
            return response()->json(['id' => $worker->id, 'name' => $worker->name]);
        }

        $input = $request->all();

        Worker::create($input);


        Session::flash('flash_message', 'Worker successfully added! <a href="' . route('workers') . '">Go back to all workers.</a>');

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
        $worker = Worker::findOrFail($id);

        return view('worker.edit')->with(['worker' => $worker]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $worker = Worker::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|unique:workers'
        ]);

        if ($request->ajax()) {
            $input = $request->all();
            $worker->fill($input)->save();
            return response()->json(['id' => $worker->id, 'name' => $worker->name]);
        }

        $input = $request->all();

        $worker->fill($input)->save();

        Session::flash('flash_message', 'Worker successfully updated!');

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
        $worker = Worker::findOrFail($id);

        if ($request->ajax()) {
            foreach ($worker->tasks as $task) :
                $task->delete();
            endforeach;
            $worker->delete();
            return 1;
        }
        $worker->delete();

        Session::flash('flash_message', 'Worker successfully deleted!');

        return redirect()->route('workers');
    }
}
