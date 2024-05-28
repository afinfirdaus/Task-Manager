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
    img {
        width: 50px;
    }

    .form {
        height: calc(100vh - 66px);
    }

    .button button {
        width: 150px;
    }

    .button a {
        width: 150px;
    }
</style>

<body>

    <nav class="navbar shadow bg-body-tertiary">
        <div class="container">
            <div class="profile d-flex">
                <div class="left-side d-flex align-items-center justify-content-center me-3">
                    <img src="{{ URL::asset('images/Manager.png') }}">
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
            <div class="link">
                <button onclick="back()" class="btn btn-primary">Back</button>
            </div>
        </div>
    </nav>

    <div class="form d-flex flex-column align-items-center justify-content-center">
        <div class="container border rounded p-4">
            @if (session('message'))
                <div class="alert alert-success text-center">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{ $task->id }}" method="POST" class="row">
                @csrf
                @method('PUT')
                <div class="col-4">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ $task->title }}">
                    @error('title')
                        <div id="title" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-4">
                    <label for="developer" class="form-label">Developer</label>
                    <select class="form-select" name="developer">
                        @foreach ($developers as $developer)
                            <option value="{{ $developer->username }}"
                                @if ($developer->username == $task->developer) {{ 'selected' }} @endif>{{ $developer->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline"
                        name="deadline" value="{{ $task->deadline }}">
                    @error('deadline')
                        <div id="deadline" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 mt-2">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="5">{{ $task->description }}</textarea>
                    @error('description')
                        <div id="deadline" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="button d-flex justify-content-evenly mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/delete/{{ $task->id }}" class="btn btn-danger">Delete</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        function back() {
            location.href = "http://127.0.0.1:8000/manager";
        }
    </script>
</body>

</html>
