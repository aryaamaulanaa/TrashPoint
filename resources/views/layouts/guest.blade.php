<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TrashPoint') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom styles for the split-screen guest layout */
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            /* Prevent scrolling */
            font-family: sans-serif;
            display: flex;
            /* Use flexbox for the main layout */
            min-height: 100vh;
            /* Full viewport height */
        }

        .left-panel {
            flex: 1;
            /* Takes up half the width */
            background-color: #4F98C8;
            /* Light blue background for the left side */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .left-panel img {
            max-width: 250px;
            /* Adjust logo size as desired */
            height: auto;
            margin-bottom: 20px;
        }

        .left-panel h1 {
            font-size: 2.5em;
            /* Large title for left panel */
            font-weight: bold;
            margin-bottom: 10px;
        }

        .left-panel p {
            font-size: 1.2em;
        }

        .right-panel {
            flex: 1;
            /* Takes up the other half */
            background-color: white;
            /* White background for the form side */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-y: auto;
            /* Allow scrolling if content is too long */
        }

        .guest-form-wrapper {
            width: 100%;
            max-width: 550px;
            /* Max width for the form inside right panel */
            padding: 40px;
            /* Background, border-radius, shadow are handled by this wrapper */
            background-color: #ffffff;
            /* Ensure white background inside */
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for the form itself */
        }

        /* Custom styles for input with icons and buttons (from previous attempt) */
        .input-with-icon {
            position: relative;
            margin-bottom: 1rem;
            /* Adjust spacing as needed */
        }

        .input-with-icon .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1.2em;
        }

        .input-with-icon input {
            padding-left: 40px !important;
            /* Beri ruang untuk ikon */
        }

        .btn-green-custom {
            background-color: #4F98C8 !important;
            border-color: #4F98C8 !important;
            color: white !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-weight: bold !important;
            transition: background-color 0.3s ease;
        }

        .btn-green-custom:hover {
            background-color: #218838 !important;
        }

        .text-indigo-custom {
            /* For links like "Daftar Sekarang" */
            color: #4f46e5;
            /* Tailwind indigo-600 */
        }

        .text-indigo-custom:hover {
            color: #4338ca;
            /* Tailwind indigo-700 */
        }
    </style>
</head>

<body>
    <div class="left-panel">
        <img src="{{ asset('images/logo-sampah.png') }}" alt="TrashPoint Logo">
        <h1 style="color: #255e31; font-size: 3em;">TRASHPOINT</h1> <!-- UBAH NILAI FONT-SIZE DI SINI -->
    </div>
    <div class="right-panel">
        <div class="guest-form-wrapper">
            {{ $slot }} {{-- Ini adalah tempat form login/register akan diinject --}}
        </div>
    </div>
</body>

</html>