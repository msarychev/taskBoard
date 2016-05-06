$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#form__createWorker').on('submit', function (e) {
        event.preventDefault();
        var form = $(this);
        $.ajax({
            url: '/worker', //Адрес подгружаемой страницы
            type: "POST", //Тип запроса
            data: $(this).serialize(),
            success: function (response) { //Если все нормально
                console.log(response);
                $('#result').html(response.message);
                $(form).remove();
            },
            error: function (response) { //Если ошибка
                $('#result').html = "Ошибка при отправке формы";
            }
        });
    });

    $(".form__delete").submit(function (event) {
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            return true;
        }
        else {
            event.preventDefault();
            return false;
        }

    });


    function refreshSortable() {
        $('.table__cell').sortable({
            connectWith: ".connectedSortable",
            placeholder: "ui-state-highlight",
            cursor: "move",
            opacity: 0.5,
            // tolerance: "pointer",
            cancel: 'form',
            helper: 'clone',
            scrollSensitivity: 0,
            scrollSpeed: 10,
            cursorAt: {left: 200, top: 50},
            scroll: false,
            stop: function (event, ui) {
                // ui.item[0].onclick = ui.item[0].oldclick;

                var item = $(ui.item);
                if (item.hasClass('table__task')) {
                    var parentCell = item.closest('.table__cell');
                    var taskId = item.attr('taskid');
                    var worker_id = $(parentCell).attr('worker');
                    var status = $(parentCell).attr('status');
                    var data = {'worker_id': worker_id, 'status': status};
                    $('.table__cell').removeClass('over');
                    updateTask(taskId, data);
                    updateTasksSort(parentCell);
                }
            },
            over: function (event, ui) {
                var item = $(ui.item);
                if (item.hasClass('table__task')) {
                    if ($(this).get(0) == $('.table__img').get(0)) {
                        $('.table__img').addClass('over');
                    }
                    else {
                        $('.table__img').removeClass('over');
                    }
                }
            }
        }).disableSelection();
        $('.table__cell').droppable({
            hoverClass: "ui-state-highlight",
            accept: "#droppable",
            drop: function (event, ui) {
                var cell = $(this);
                var worker_id = cell.attr('worker');
                var status = cell.attr('status');
                var popup = new $.Popup();
                popup.open($('.popup-task'));

                var popupForm = $('.form__task');
                popupForm.find('option[value=' + worker_id + ']').attr('selected', 'selected');
                popupForm.find('option[value=' + status + ']').attr('selected', 'selected');
                popupForm.on('submit', function (event) {
                    event.preventDefault();
                    createTask($(this), cell, popup);
                    updateTasksSort(cell);
                });
            }
        }).disableSelection();
    }

    refreshSortable();

    $('.table__img').droppable({
        accept: ".table__task",
        hoverClass: "over",
        drop: function (event, ui) {
            var taskId = ui.draggable.attr('taskid');
            if (deleteTask(taskId)) {
                ui.draggable.remove();
            }
        }
    });

    $('#droppable').draggable({
        helper: 'clone',
        refreshPositions: false,
        cursorAt: {left: 50, top: 50},
        scroll: true
    });


    $('body').on('click', '.table__task', function () {
        console.log('ad');
        var task = $(this);
        var id = task.attr('taskid');
        var name = task.find('.task__name').html();
        var description = task.find('.task__desc').html();
        var worker_id = task.parent().attr('worker');
        var status = task.parent().attr('status');
        var time = task.find('.task__time').html();

        var popup = new $.Popup();
        popup.open($('.popup-updateTask'));

        var popupForm = $('.form__updateTask');
        popupForm.attr('action', '/task/' + id);
        popupForm.find('#name').val(name);
        popupForm.find('#time').val(time);
        popupForm.find('#description').val(description);
        popupForm.find('option[value=' + worker_id + ']').attr('selected', 'selected');
        popupForm.find('option[value=' + status + ']').attr('selected', 'selected');
        popupForm.on('submit', function (event) {
            event.preventDefault();
            updateFormTask($(this), id, task, popup)
        });
    });

    $('body').on('click', '.worker__name', function () {
        var worker = $(this);
        var id = worker.attr('workerid');
        var name = worker.html();

        var popup = new $.Popup();
        popup.open($('.popup-updateWorker'));

        var popupForm = $('.form__updateWorker');
        popupForm.attr('action', '/worker/' + id);
        popupForm.find('#name').val(name);
        popupForm.on('submit', function (event) {
            event.preventDefault();
            updateFormWorker($(this), id, worker, popup)
        });
    });

    $('body').on('click', '.worker__delete', function () {
        var trash = $(this);
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            var data = {};
            data._token = $('#csrf').val();
            data._method = 'DELETE';
            $.ajax({
                type: 'POST',
                url: '/worker/' + $(this).attr('workerid'),
                data: data,
                success: function () {
                    trash.closest('tr').remove();
                    $('option[value=' + trash.attr("workerid") + ']').remove();
                },
                error: function () {
                    location.reload();
                    return false;
                }

            });
            return true;
        }
        else {
            // event.preventDefault();
            return false;
        }
    });

    $('body').on('click', '.worker__add', function () {
        var popup = new $.Popup();
        popup.open($('.popup-newWorker'));

        var popupForm = $('.form__newWorker');
        popupForm.on('submit', function (event) {
            event.preventDefault();
            createWorker($(this), popup)
        });
    });

    function createWorker(form, popup) {
        var data = form.serialize();
        $.ajax({
            type: 'POST',
            url: '/worker',
            data: data,
            error: function (data) {
                var errors = JSON.parse(data.responseText);
                var errContainer = form.closest('.container').find('.alert');
                errContainer.html('');
                errContainer.css('display', 'block');
                $.each(errors, function (index, value) {
                    errContainer.append('<p>' + value + '</p>');
                });
            },
            success: function (data) {
                var types = ['ToDo', 'InProgress', 'Done'];
                var html =
                    '<tr>' +
                    '<td>' +
                    '<a href="/' + data.id + '">' +
                    '<img src="/img/eye.png" alt="" class="worker__observe">' +
                    '</a>' +
                    '<br>' +
                    '<span workerid="' + data.id + '" class="worker__name">' + data.name + '</span>' +
                    '<br>' +
                    '<img workerid="' + data.id + '" src="/img/trash-empty.png" alt="" class="worker__delete">' +
                    '</td>';
                $.each(types, function (index, value) {
                    html = html + '<td id="table_cell" class="connectedSortable table__cell .col-md-4" worker="' + data.id + '" status="' + value + '">' +
                        '</td>';
                });
                html = html + '</tr>';
                $('tbody').append(html);

                $('select[name=worker_id]').append($("<option></option>")
                    .attr("value", data.id)
                    .text(data.name));
                refreshSortable();
                popup.close();
            }
        });
    }

    function updateFormWorker(form, workerId, worker, popup) {
        var data = form.serialize();
        $.ajax({
            type: 'POST',
            url: '/worker/' + workerId,
            data: data,
            error: function (data) {
                var errors = JSON.parse(data.responseText);
                var errContainer = form.closest('.container').find('.alert');
                errContainer.html('');
                errContainer.css('display', 'block');
                $.each(errors, function (index, value) {
                    errContainer.append('<p>' + value + '</p>');
                });
            },
            success: function (data) {
                worker.html(data.name);
                $('option[value=' + data.id + ']').remove();
                $('select[name=worker_id]').append($("<option></option>")
                    .attr("value", data.id)
                    .text(data.name));
                popup.close();
            }
        });
    }

    function updateTasksSort(cell) {
        var i = 1;
        cell.find('.table__task').each(function () {
            var id = $(this).attr('taskid');
            var data = {'sort': i};
            updateTask(id, data);
            i++;
        });
    }

    function updateTask(taskId, data) {
        data._method = 'PATCH';
        $.ajax({
            type: 'POST',
            url: '/task/' + taskId,
            data: data,
            error: function () {
                location.reload();
            }
        });
    }

    function updateFormTask(form, taskId, task, popup) {
        var data = form.serialize();
        $.ajax({
            type: 'POST',
            url: '/task/' + taskId,
            data: data,
            error: function (data) {
                var errors = JSON.parse(data.responseText);
                var errContainer = form.closest('.container').find('.alert');
                errContainer.html('');
                errContainer.css('display', 'block');
                $.each(errors, function (index, value) {
                    errContainer.append('<p>' + value + '</p>');
                });
            },
            success: function (data) {
                task.find('.task__name').html(data.name);
                task.find('.task__desc').html(data.description);
                task.find('.task__time').html(data.time);
                popup.close();
            }
        });
    }

    function deleteTask(taskId) {
        var data = {};
        data._method = 'DELETE';
        $.ajax({
            type: 'POST',
            url: '/task/' + taskId,
            data: data,
            error: function () {
                location.reload();
                return false;
            }
        });
        return true;
    }

    function createTask(form, cell, popup) {
        var data = form.serialize();
        $.ajax({
            type: 'POST',
            url: '/task',
            data: data,
            error: function (data) {
                var errors = JSON.parse(data.responseText);
                var errContainer = form.closest('.container').find('.alert');
                errContainer.html('');
                errContainer.css('display', 'block');
                $.each(errors, function (index, value) {
                    errContainer.append('<p>' + value + '</p>');
                });
            },
            success: function (data) {
                var html =
                    '<div draggable="true" taskId=' + data.id + ' class="table__task sticker bg-warning">' +
                    '<div class="task__name">' + data.name + '</div>' +
                    '<div class="task__desc">' + data.description + '</div>' +
                    '<div class="task__time">' + data.time + '</div>' +
                    '</div>';
                cell.prepend(html);
                popup.close();
            }
        });
    }

});