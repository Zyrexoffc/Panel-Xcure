<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Protect Settings</title>
    <link rel="stylesheet" href="{{ mix('tailwind.css') }}">
    <style>
        body { background: #1a1a2e; color: white; font-family: Arial; }
        .container { max-width: 600px; margin: 50px auto; padding: 30px; background: #16213e; border-radius: 10px; }
        .switch { position: relative; display: inline-block; width: 60px; height: 34px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px; }
        .slider:before { position: absolute; content: ""; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: #2196F3; }
        input:checked + .slider:before { transform: translateX(26px); }
    </style>
</head>
<body>
    <div class="container">
        <h2>Server Protect: {{ $server->name }}</h2>
        <p>Jika diaktifkan, hanya owner yang dapat mengakses server (console, files, power, dll).</p>
        <form method="POST" action="{{ route('server.protect.toggle', ['identifier' => $server->uuid_short]) }}">
            @csrf
            <label class="switch">
                <input type="checkbox" name="protected" onchange="this.form.submit()" {{ $server->protected ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <span style="margin-left: 10px;">{{ $server->protected ? 'AKTIF' : 'NONAKTIF' }}</span>
        </form>
        <br>
        <a href="/server/{{ $server->uuid_short }}" style="color: #2196F3;">Kembali ke Server</a>
    </div>
</body>
</html>
