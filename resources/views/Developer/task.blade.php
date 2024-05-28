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
        color: inherit;
        text-decoration: none;
    }

    a {
        background:
            linear-gradient(to right,
                rgba(100, 200, 200, 1),
                rgba(100, 200, 200, 1)),
            linear-gradient(to right,
                rgba(255, 0, 0, 1),
                rgba(255, 0, 180, 1),
                rgba(0, 100, 200, 1));
        background-size: 100% 3px, 0 3px;
        background-position: 100% 100%, 0 100%;
        background-repeat: no-repeat;
        transition: background-size 400ms;
    }

    a:hover {
        background-size: 0 3px, 100% 3px;
    }

    img {
        width: 50px;
    }

    .content {
        height: calc(100vh - 66px);
    }

    .card-text {
        max-height: 300px;
    }

    nav .pagination {
        margin-bottom: 0px;
    }

    .chat {
        height: 100vh;
    }

    .box {
        height: 600px;
        width: 800px;
    }

    .top {
        max-height: 550px;
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
            <div class="back">
                <a href="/developer">Back</a>
            </div>
        </div>
    </nav>

    <div class="content d-flex align-items-center">
        <div class="container">'
            <div class="task">
                @foreach ($tasks as $task)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <h6 class="card-subtitle text-body-secondary">Deadline : {{ $task->deadline }}</h6>
                            <p class="card-text border-top mt-3 overflow-auto">
                                {{ $task->description }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <form action="/task/{{ $task->id }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary"
                                        @if ($task->status == 1 || $task->deadline <= $currentdate) {{ 'disabled' }} @endif>Finish</button>
                                </form>
                                {{ $tasks->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="chat d-flex align-items-center">
        <div class="container d-flex justify-content-center">
            <div class="box d-flex flex-column justify-content-between">
                <div class="top overflow-auto">
                    @foreach ($comments as $comment)
                        @if ($comment->project_id == $projectid)
                            <div class="name">
                                {{ $comment->user->username }} :
                            </div>
                            <div class="comment mb-2">
                                {{ $comment->comment }}
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="bottom">
                    <form action="/comment/{{ $tasks[0]->project_id }}" method="POST" class="input-group">
                        @csrf
                        <input type="text" class="form-control" placeholder="Comment" name="comment" required
                            autocomplete="off">
                        <button class="btn btn-outline-secondary" type="submit">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
