<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login — Finora</title>
    </head>

    <body>
        <main>
            <h1>Finora</h1>
            <h2>Login</h2>
        @if (session('status'))
            <p>{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" >
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" >
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>

                <button type="submit">Login</button>
            </form>

            <p>
                Don't have an account?
                <a href="{{ route('register') }}">Register</a>
            </p>
        </main>
    </body>
</html>