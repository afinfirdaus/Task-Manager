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

    button {
        position: relative;
        display: inline-block;
        padding: 15px 30px;
        text-align: center;
        font-size: 18px;
        letter-spacing: 1px;
        text-decoration: none;
        color: #5BBCFF;
        background: transparent;
        cursor: pointer;
        transition: ease-out 0.5s;
        border: 2px solid #5BBCFF;
        border-radius: 10px;
        box-shadow: inset 0 0 0 0 #5BBCFF;
    }

    button:hover {
        color: white;
        box-shadow: inset 0 -100px 0 0 #5BBCFF;
    }

    button:active {
        transform: scale(0.9);
    }


    .content {
        height: calc(100vh - 68px);
    }

    .form {
        width: 350px;
    }

    img {
        width: 185px;
    }
</style>

<body>

    <nav class="navbar shadow bg-body-tertiary">
        <div class="container">
            <div class="brand">
                <img src="Images/Logo.png">
            </div>
            <div class="link">
                <a href="register">Register</a>
            </div>
        </div>
    </nav>

    <div class="content container d-flex flex-column align-items-center justify-content-center">
        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <div class="form border rounded d-flex flex-column justify-content-center p-5">
            <form action="/" method="POST" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email">
                    @error('email')
                        <div id="email" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                    @error('password')
                        <div id="password" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="button d-flex flex-column justify-content-center">
                    <button type="submit" class="flex-grow">Login</button>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
