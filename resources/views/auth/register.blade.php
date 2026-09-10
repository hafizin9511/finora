<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register — Finora</title>
    </head>

    <body>
        <main>
            <h1>Finora</h1>
            <h2>Create your account</h2>
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

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div>
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" >
                </div>

                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" >
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" >
                </div>

                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" >
                </div>

                <button type="submit">Create Account</button>
            </form>

            <p>
                Already have an account?
                <a href="{{ route('login') }}">Login</a>
            </p>
        </main>
    </body>
</html>