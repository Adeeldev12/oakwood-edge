<!DOCTYPE html>
<html lang="en">
{{-- <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Oakwood Edge</title>

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            background: #ffffff;
            padding: 4rem 5rem;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 20px 45px rgba(0,0,0,0.12);
            max-width: 520px;
            width: 100%;
        }

        .card img {
            height: 230px; /* LOGO SIZE */
            margin-bottom: 0.1rem;
        }

        .card h1 {
            font-size: 2.25rem;
            margin-bottom: 0.75rem;
            color: #111827;
        }

        .card p {
            font-size: 1.05rem;
            color: #6b7280;
            margin-bottom: 2.5rem;
        }

        .card a {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: #7b9eea;
            color: #ffffff;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .card a:hover {
            background: #1d4ed8;
        }
    </style>
</head> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Oakwood Edge</title>

    <!-- FAVICON (GLOBAL FOR THIS PAGE) -->
    <link
        rel="icon"
        type="image/webp"
        href="{{ asset('images/OakWood Logo Logo Mark (1).webp') }}"
    >

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            background: #ffffff;
            padding: 4rem 5rem;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 20px 45px rgba(0,0,0,0.12);
            max-width: 520px;
            width: 100%;
        }

        .card img {
            height: 230px;
            margin-bottom: 0.1rem;
        }

        .card h1 {
            font-size: 2.25rem;
            margin-bottom: 0.75rem;
            color: #111827;
        }

        .card p {
            font-size: 1.05rem;
            color: #6b7280;
            margin-bottom: 2.5rem;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .card a {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: #7b9eea;
            color: #ffffff;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
            transition: background 0.2s ease;
        }

        .card a:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>

    <div class="card">
        <img
            src="{{ asset('images/Untitled design.png') }}"
            alt="Oakwood Edge"
        >

        {{-- <h1>Oakwood Edge</h1>
        <p>Independent Medico-Legal Experts Supporting Complex Legal Cases</p> --}}

        <div class="buttons">
            <a href="{{ url('/admin') }}">
                  <b>Admin Login</b>
            </a>

            <a href="{{ url('/admin') }}">
                <b>User Login</b>
            </a>
        </div>
    </div>

</body>
</html>
