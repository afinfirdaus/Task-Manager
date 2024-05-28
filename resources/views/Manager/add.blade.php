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
    .button-19 {
        appearance: button;
        background-color: #1899D6;
        border: solid transparent;
        border-radius: 16px;
        border-width: 0 0 4px;
        box-sizing: border-box;
        color: #FFFFFF;
        cursor: pointer;
        display: inline-block;
        font-family: din-round, sans-serif;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: .8px;
        line-height: 20px;
        margin: 0;
        outline: none;
        overflow: visible;
        padding: 13px 16px;
        text-align: center;
        text-transform: uppercase;
        touch-action: manipulation;
        transform: translateZ(0);
        transition: filter .2s;
        user-select: none;
        -webkit-user-select: none;
        vertical-align: middle;
        white-space: nowrap;
        width: 100%;
    }

    .button-19:after {
        background-clip: padding-box;
        background-color: #1CB0F6;
        border: solid transparent;
        border-radius: 16px;
        border-width: 0 0 4px;
        bottom: -4px;
        content: "";
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        z-index: -1;
    }

    .button-19:main,
    .button-19:focus {
        user-select: auto;
    }

    .button-19:hover:not(:disabled) {
        filter: brightness(1.1);
        -webkit-filter: brightness(1.1);
    }

    .button-19:disabled {
        cursor: auto;
    }

    .button-19:active {
        border-width: 4px 0 0;
        background: none;
    }

    img {
        width: 50px;
    }

    .form {
        height: calc(100vh - 66px);
    }

    .button button {
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
        <div class="container border p-4">
            <form action="{{ $project_id }}" method="POST" class="row">
                @csrf
                <div class="col-4">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title">
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
                            <option value="{{ $developer->username }}">{{ $developer->username }}</option>
                        @endforeach
                    </select>
                    @error('developer')
                        <div id="title" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-4">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline"
                        name="deadline">
                    @error('deadline')
                        <div id="deadline" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 mt-2">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="5"></textarea>
                    @error('description')
                        <div id="deadline" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="button d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary">Add</button>
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
