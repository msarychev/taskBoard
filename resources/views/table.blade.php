@extends('welcome')
@section('content')
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th></th>
            <th>ToDo</th>
            <th>In Progress</th>
            <th>Done</th>
        </tr>
        </thead>
        <tbody>
        @foreach($workers as $worker)
            <tr>
                <td>
                    <a href="/{{$worker->id}}">
                        <img src="/img/eye.png" alt="" class="worker__observe">
                    </a>
                    <br>
                    <span workerid="{{$worker->id}}" class="worker__name">{{$worker->name}}</span>
                    <br>
                    <img workerid="{{$worker->id}}" src="/img/trash-empty.png" alt="" class="worker__delete">
                </td>
                @foreach(['ToDo', 'InProgress', 'Done'] as $status)
                    <td id="table_cell" class="connectedSortable table__cell .col-md-4" worker="{{$worker->id}}" status="{{$status}}">
                        @foreach($worker->getTasksByStatus($status) as $task)
                            <div draggable="true" taskId="{{$task->id}}" class="table__task sticker">
                                <div class="task__name">{{$task->name}}</div>
                                <div class="task__desc">{{$task->description}}</div>
                                <div class="task__time">{{$task->time == 0 ? '' : $task->time}}</div>
                            </div>
                        @endforeach
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    <img src="/img/plus.png" alt="" class="worker__add">

    <div class="fixed-left">
        <span id="droppable" class="new-drop sticker">Create a new task</span>
    </div>
    <div class="fixed-right">
        <img src="/img/trash-empty.png" alt="" class="table__img ">
    </div>

    <div class="popup-task hidden">
        @include('task.new_popup')
    </div>

    <div class="popup-updateTask hidden">
        @include('task.edit_popup')
    </div>

    <div class="popup-updateWorker hidden">
        @include('worker.edit_popup')
    </div>

    <div class="popup-newWorker hidden">
        @include('worker.new_popup')
    </div>


@endsection
