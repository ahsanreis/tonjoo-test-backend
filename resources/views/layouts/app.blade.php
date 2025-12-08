<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     @vite('resources/css/app.css')
     <title>Tonjoo Backend</title>
</head>

<body>
     <div class="flex flex-col md:flex-row min-h-screen">
          <aside class="w-full md:w-64 bg-gray-800 text-white p-4">
               @include('components.sidebar')
          </aside>

          <main class="flex-1 bg-gray-100 p-8">
               <h1 class="text-3xl font-bold mb-6">@yield('title')</h1>
               <div class="bg-white p-6 rounded-lg shadow-md">
                    @yield('content')
               </div>
          </main>
     </div>
     @flasher_render
     @stack('scripts')
</body>

</html>