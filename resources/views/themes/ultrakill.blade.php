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
                {{-- "When life gives you lemon." - Elbert Hubbard --}}
                @php
                    $random_quotes = [
                        '"Mankind is dead. Blood is fuel. Hell is full." - ???',
                        '"I WILL CUT YOU DOWN! Break you apart, splay the gore of your profane form across the STARS! I will grind you down until the very SPARKS CRY FOR MERCY! My hands shall RELISH ENDING YOU... HERE! AND! NOW!" - Gabriel, Supreme Angel'
                    ];
                @endphp
                {{ $random_quotes[array_rand($random_quotes)]; }}
            </p>
        </div>
    </div>

    <p class="fixed text-[14px] text-gray-600 bottom-1 left-1">
        Codesome & Gemini - 2026
    </p>

    <!-- Theme Switcher (Fall-up Menu) -->
    <div class="fixed bottom-4 right-4 z-50 flex flex-col items-end">
        
        <div id="theme-menu" class="mb-4 flex flex-col items-end gap-4 transition-all duration-300 origin-bottom scale-90 opacity-0 pointer-events-none">
            
            <a href="{{ route('theme.switch', 'miside') }}" class="w-30 h-12 rounded-full bg-white shadow-lg hover:scale-110 transition-transform overflow-hidden border border-gray-100 cursor-pointer">
                <img src="{{ asset('images/miside-title.png') }}" alt="Miside" class="w-full h-full object-cover">
            </a>
            
            <a href="{{ route('theme.switch', 'default') }}" class="flex justify-center items-center w-30 h-12 rounded-full bg-white shadow-lg hover:scale-110 transition-transform overflow-hidden border border-gray-100 cursor-pointer">
                <span class="font-bold italic">Default</span>
            </a>
            
            <a href="{{ route('theme.switch', 'terraria') }}" class="w-30 h-12 rounded-full bg-white shadow-lg hover:scale-110 transition-transform overflow-hidden border border-gray-100 cursor-pointer px-2">
                <img src="{{ asset('images/terraria-title.png') }}" alt="Calamity" class="w-full h-full object-contain">
            </a>
            
        </div>

        <!-- Trigger Button -->
        <button onclick="toggleThemeMenu()" class="cursor-pointer bg-gray-900 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-gray-700 transition-transform hover:-translate-y-1">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
            </svg>
        </button>
    </div>

    <!-- The Toggle Script -->
    <script>
        function toggleThemeMenu() {
            const menu = document.getElementById('theme-menu');
            // Toggle the Tailwind animation classes
            menu.classList.toggle('scale-95');
            menu.classList.toggle('scale-100');
            menu.classList.toggle('opacity-0');
            menu.classList.toggle('opacity-100');
            menu.classList.toggle('pointer-events-none');
        }
    </script>
</body>
</html>