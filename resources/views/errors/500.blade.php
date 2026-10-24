<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>500 Server Error - {{ config('app.name') }}</title>
 <script src="https://cdn.tailwindcss.com"></script>
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
 <style>
 body {
 font-family: 'Inter', sans-serif;
 }
 </style>
</head>

<body class="bg-page flex items-center justify-center min-h-screen p-6">
 <div class="max-w-md w-full text-center">
 <div class="mb-8 flex justify-center">
 <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center">
 <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
 </svg>
 </div>
 </div>
 <h1 class="text-4xl font-bold text-txmain mb-4">500</h1>
 <h2 class="text-xl font-semibold text-txmain mb-4">Something Went Wrong</h2>
 <p class="text-txmain mb-8">
 Something went wrong on our end. Please try again in a few minutes. If the problem continues, please contact support.
 </p>
 <div class="space-y-4">
 <a href="{{ url('/') }}"
 class="inline-block w-full bg-brand-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-brand-700 transition duration-200">
 Go to Dashboard
 </a>
 </div>
 </div>
</body>

</html>
