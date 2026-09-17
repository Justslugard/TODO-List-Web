<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f4f6] min-h-screen flex items-center justify-center p-4 font-sans text-gray-800">

    <div class="bg-white w-full max-w-xl p-8 sm:p-12 rounded-2xl shadow-sm">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Add new task!</h1>

        <form action="{{ route("todo.store") }}" method="POST" class="flex items-center mb-10">
            <input
                type="text" 
                name="title" 
                placeholder="Feed the alligators, get a girlfriend, e.g"
                maxlength="255"
                minlength="3"
                required
                class="grow border-b-2 border-gray-300 focus:border-gray-600 invalid:border-red-300 focus:invalid:border-red-600 outline-none py-2 text-gray-700 placeholder-gray-400 transition-color invalid:text-red-500">
                {{-- class="grow border-b-2 border-gray-300 focus:border-gray-600 @error("title") border-red-300 border-red-600 text-red-500 @enderror outline-none py-2 text-gray-700 placeholder-gray-400 transition-color"> --}}
                {{-- @error("title")
                    <p class="grow">{{ $message }}</p>                    
                @enderror --}}
                <button type="submit" class="ml-5 pb-1 bg-gray-700 hover:bg-gray-900 text-white rounded-lg w-9 h-9 flex items-center justify-center text-2xl font-bold transition-colors">
                    +
                </button>
        </form>
    </div>
</body>
</html>