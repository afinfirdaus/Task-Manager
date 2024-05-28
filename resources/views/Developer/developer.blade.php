<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
    a {
        text-decoration: none;
        color: inherit;
    }

    img {
        width: 50px;
    }

    .content {
        height: calc(100vh - 66px);
    }

    .card-body {
        max-height: 350px;
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
                    <img src="{{ URL::asset('Images/Developer.png') }}">
                </div>
                <div class="right-side">
                    <div class="name">
                        <p class="m-0 fw-bold">{{ ucfirst(trans(Auth::user()->username)) }}</p>
                    </div>
                    <div class="role">
                        <p class="m-0">Developer</p>
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

    <div class="content d-flex align-items-center">
        <div class="container">
            <div class="card text-bg-light">
                <div class="card-header">Project List</div>
                <div class="card-body pb-0 overflow-auto">
                    @foreach ($tasks->unique('project_id') as $task)
                        <a href="/task/{{ $task->project_id }}" class="task d-flex justify-content-between mb-3">
                            <div class="title">
                                {{ $task->project->title }}
                            </div>
                            <div class="status d-flex align-items-center">
                                <div class="red"></div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
