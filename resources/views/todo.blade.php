<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f4f6] min-h-screen flex items-center justify-center p-4 font-sans text-gray-800">

    <!-- Main Card -->
    <div class="bg-white w-full max-w-xl p-8 sm:p-12 rounded-2xl shadow-sm">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Your To Do</h1>

        <!-- Add Task Form -->
        <form action="{{ route('todo.store') }}" method="POST" class="flex items-center mb-10">
            @csrf
            <input 
                type="text" 
                name="title" 
                placeholder="Add new task" 
                required
                class="grow border-b-2 border-gray-300 focus:border-gray-600 outline-none py-2 text-gray-700 placeholder-gray-400 transition-colors"
            >
            <button type="submit" class="ml-4 pb-1 bg-gray-700 hover:bg-gray-900 text-white rounded-lg w-9 h-9 flex items-center justify-center text-2xl font-light transition-colors">
                +
            </button>
        </form>

        <!-- Task List -->
        <div class="space-y-3">
            @foreach($todos as $todo)
                <div class="border border-gray-300 rounded-xl p-4 flex items-center justify-between">
                    
                    <!-- Checkbox Form -->
                    <form action="{{ route('todo.update', $todo->id) }}" method="POST" class="flex items-center grow">
                        @csrf
                        @method('PATCH')
                        
                        <!-- onChange="this.form.submit()" automatically saves when clicked -->
                        <input 
                            type="checkbox" 
                            onChange="this.form.submit()"
                            {{ $todo->status ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 hover:bg-gray-600 text-gray-700 cursor-pointer accent-gray-600"
                        >
                        
                        <!-- Dynamic Text Styling based on status -->
                        <span class="ml-4 {{ $todo->status ? 'line-through text-gray-400' : 'text-gray-700 font-medium' }}">
                            {{ $todo->title }}
                        </span>
                    </form>

                    <!-- Delete Button Form -->
                    <form action="{{ route('todo.destroy', $todo->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 cursor-pointer hover:text-red-500 font-bold ml-4 text-lg transition-colors">
                            ×
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Footer Stats -->
        <div class="mt-8 pt-4">
            <p class="font-bold text-sm text-gray-700">
                Your remaining todos : {{ $todos->where('status', false)->count() }}
            </p>
            <p class="italic text-gray-400 mt-2 text-sm">
                "When life gives you lemon." - Wayne Dyer
            </p>
        </div>
    </div>

</body>
</html>