<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
    .list-box {
        height: calc(100vh - 66px);
    }

    .box {
        min-width: 260px;
    }

    .box .body {
        max-height: 260px;
    }

    .littleform .input-group {
        min-width: 250px;
        min-height: 50px;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    img {
        width: 50px;
    }

    svg {
        cursor: pointer;
    }

    .green {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: green;
    }

    .red {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: red;
    }
</style>

<body>

    <nav class="navbar shadow bg-body-tertiary">
        <div class="container">
            <div class="profile d-flex">
                <div class="left-side d-flex align-items-center justify-content-center me-3">
                    <img src="{{ URL::asset('Images/Manager.png') }}">
                </div>
                <div class="right-side">
                    <div class="name">
                        <p class="m-0 fw-bold">{{ ucfirst(trans(Auth::user()->username)) }}</p>
                    </div>
                    <div class="role">
                        <p class="m-0">Manager</p>
                    </div>
                </div>
            </div>
            <div class="logout">
                <form action="logout" method="POST">
                    @csrf
                    <button class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="list-box d-flex align-items-center overflow-x-auto px-5">
        @foreach ($projects as $project)
            <div class="box-wrapper me-3">
                @if ($project->progress != 0)
                    {{-- <div class="progress mb-2" role="progressbar" aria-label="Success example" aria-valuemin="0"
                        aria-valuemax="100">
                        <div class="progress-bar bg-success" style="width: {{ $project->progress }}%"></div>
                    </div> --}}
                    <div class="progress mb-2" role="progressbar" aria-label="Animated striped example" aria-valuemin="0"
                        aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                            style="width: {{ $project->progress }}%"></div>
                    </div>
                @endif
                <div class="box border rounded">
                    <div class="head d-flex justify-content-between mb-2 p-2">
                        <div class="title">{{ $project->title }}</div>
                        <div class="option">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-three-dots" viewBox="0 0 16 16" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <path
                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                            </svg>
                            <div class="option dropdown">
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="add/{{ $project->id }}">Add Task</a></li>
                                    <li><a class="delete dropdown-item" href="#"
                                            data-id="{{ $project->id }}">Delete Project</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="body overflow-auto">
                        <div class="list-task overflow-auto">
                            @foreach ($tasks as $task)
                                @if ($task->project_id == $project->id)
                                    <div class="task p-2">
                                        <a href="/edit/{{ $task->id }}" class="d-flex justify-content-between">
                                            <div class="name">{{ $task->title }}</div>
                                            <div class="status d-flex align-items-center ms-5">
                                                @if ($task->status == 1)
                                                    <div class="green"></div>
                                                @else
                                                    <div class="red"></div>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="littleform">
            <form id="project">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Project Title" name="title">
                    <button class="btn btn-outline-secondary" type="submit" id="button">Add</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {

            $('#project').submit(function(event) {

                event.preventDefault();

                let form = $('#project')[0];
                let data = new FormData(form);

                $.ajax({
                    type: "POST",
                    url: "{{ url('store') }}",
                    data: data,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        $("input[type='text']").val('');
                        $('<div class="box border rounded me-3"><div class="head d-flex justify-content-between mb-2 p-2"><div class="title">' +
                            response.title +
                            '</div><div class="option"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16" data-bs-toggle="dropdown" aria-expanded="false"><path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" /></svg><div class="option dropdown"><ul class="dropdown-menu"><li><a class="dropdown-item" href=add/' +
                            response.recent.id +
                            '>Add Task</a></li><li><a class="delete dropdown-item" href="#" data-id=' +
                            response.recent.id +
                            '>Delete Project</a></li></ul></div></div></div></div>'
                        ).insertBefore(".littleform");
                    },

                    error: function() {
                        alert('Empty Field!!!');
                    }
                })
            });

            $('.delete').click(function(event) {
                let url = "delete-project/" + $(this).attr('data-id');
                let obj = $(this);
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        $(obj).parent().parent().parent().parent().parent().parent().parent()
                            .remove();
                    }

                    // error:function(response){

                    // }
                })
            })
        });
    </script>
</body>

</html>
