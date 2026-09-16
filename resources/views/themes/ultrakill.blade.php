<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ULTRA-TODO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* B&W Terminal Scrollbar */
        .ultra-scroll::-webkit-scrollbar {
            width: 8px;
        }
        .ultra-scroll::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.8);
            border-left: 1px solid #333;
        }
        .ultra-scroll::-webkit-scrollbar-thumb {
            background: #fff;
        }
        .ultra-scroll::-webkit-scrollbar-thumb:hover {
            background: #ccc;
        }

        /* Octagonal Corner Cuts */
        .clip-octagon {
            clip-path: polygon(25px 0, 100% 0, 100% calc(100% - 25px), calc(100% - 25px) 100%, 0 100%, 0 25px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-start pl-8 lg:pl-32 p-4 font-['VCR'] overflow-hidden text-white text-xl tracking-wider uppercase">

    <!-- Separated Video (Muted, Autoplays) -->
    <video id="bg-video" autoplay loop muted playsinline class="fixed inset-0 w-full h-full object-fill">
        <source src="{{ asset('videos/ultrakill-bg.mp4') }}" type="video/mp4">
    </video>

    <!-- Separated Audio -->
    <audio id="bg-music" loop>
        <source src="{{ asset('audio/ultrakill-music.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- Audio Toggle Button -->
    <button onclick="toggleAudio()" id="audio-btn" class="fixed top-6 right-8 border-2 border-white bg-black px-4 py-2 hover:bg-white hover:text-black transition-colors z-50 cursor-pointer">
        AUDIO : OFF
    </button>

    <!-- Main Menu Card (Sized like Default, left-aligned, octagonal) -->
    <div class="bg-black/90 w-full max-w-xl sm:p-8 clip-octagon border-2 border-white shadow-2xl relative">
        
        <h1 class="text-4xl text-center mb-10 tracking-widest">-- TODO --</h1>

        <!-- Add Task Form -->
        <div class="mb-8">
            <form action="{{ route('todo.store') }}" method="POST" class="flex gap-4">
                @csrf
                <input 
                    type="text" 
                    name="title" 
                    placeholder="-- ENTER NEW DIRECTIVE --" 
                    required
                    class="grow bg-transparent border-2 border-white focus:border-gray-400 outline-none px-4 py-2 text-white placeholder-gray-600 transition-colors uppercase"
                >
                <button type="submit" class="border-2 border-white bg-black hover:bg-white hover:text-black px-6 py-2 transition-colors cursor-pointer">
                    ADD
                </button>
            </form>
        </div>

        <!-- Task List (Strictly Scrollable Area) -->
        <div class="space-y-4 max-h-40 overflow-y-auto ultra-scroll pr-4 mb-8">
            @foreach($todos as $todo)
                <div class="flex items-center justify-between group">
                    
                    <form action="{{ route('todo.update', $todo->id) }}" method="POST" class="flex items-center grow gap-4">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Custom [X] Checkbox -->
                        <input 
                            type="checkbox" 
                            onChange="this.form.submit()"
                            {{ $todo->status ? 'checked' : '' }}
                            class="appearance-none w-8 h-8 border-2 border-white bg-black cursor-pointer relative checked:before:content-['X'] checked:before:absolute checked:before:top-1/2 checked:before:left-1/2 checked:before:-translate-x-1/2 checked:before:-translate-y-1/2 checked:before:text-white checked:before:text-2xl hover:bg-white/10 transition-colors"
                        >
                        
                        <span class="{{ $todo->status ? 'line-through text-gray-500' : 'text-white' }}">
                            {{ $todo->title }}
                        </span>
                    </form>

                    <form action="{{ route('todo.destroy', $todo->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 border-2 border-transparent text-gray-500 hover:border-white hover:text-white flex items-center justify-center transition-colors cursor-pointer font-bold text-2xl">
                            ×
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Footer Stats -->
        <div class="pt-6 border-t-2 border-gray-600 text-center">
            <p class="text-gray-300 mb-4">
                REMAINING : {{ $todos->where('status', false)->count() }}
            </p>
            <p class="text-gray-500 text-sm leading-relaxed">
                @php
                    $random_quotes = [
                        "\"Mankind is dead.\nBlood is fuel.\nHell is full.\"\n - ???",
                        "\"I WILL CUT YOU DOWN! Break you apart, splay the gore of your profane form across the STARS! I will grind you down until the very SPARKS CRY FOR MERCY! My hands shall RELISH ENDING YOU... HERE! AND! NOW!\"\n - Gabriel, Supreme Angel",
                        "\"Creature of steel, my gratitude upon thee for my freedom. But the crimes thy kind have committed against humanity are NOT forgotten! And thy punishment...\n is DEATH!\"\n - Minos Prime",
                        "\"Get Gud\" - Hakita, Developer"
                    ];
                @endphp
                {!! nl2br(e($random_quotes[array_rand($random_quotes)])) !!}
            </p>
        </div>
    </div>

    <!-- Fall-up Menu Theme Switcher -->
    <div class="fixed bottom-6 right-8 z-50 flex flex-col items-end">
        <div id="theme-menu" class="mb-4 flex flex-col items-end gap-4 transition-all duration-300 origin-bottom scale-90 opacity-0 pointer-events-none">
            
            <a href="{{ route('theme.switch', 'miside') }}" class="w-28 h-10 border-2 border-white bg-black hover:bg-white hover:text-black transition-colors flex items-center justify-center text-sm cursor-pointer">
                MISIDE
            </a>
            
            <a href="{{ route('theme.switch', 'default') }}" class="w-28 h-10 border-2 border-white bg-black hover:bg-white hover:text-black transition-colors flex items-center justify-center text-sm cursor-pointer">
                DEFAULT
            </a>
            
            <a href="{{ route('theme.switch', 'terraria') }}" class="w-28 h-10 border-2 border-white bg-black hover:bg-white hover:text-black transition-colors flex items-center justify-center text-sm cursor-pointer">
                TERRARIA
            </a>
            
        </div>

        <button onclick="toggleThemeMenu()" class="border-2 border-white bg-black text-white hover:bg-white hover:text-black transition-colors px-4 py-2 cursor-pointer">
            THEMES
        </button>
    </div>

    <p class="fixed text-[12px] text-gray-500 bottom-3 left-5">
        CODESOME & GEMINI - 2026
    </p>

    <script>
        function toggleThemeMenu() {
            const menu = document.getElementById('theme-menu');
            menu.classList.toggle('scale-90');
            menu.classList.toggle('scale-100');
            menu.classList.toggle('opacity-0');
            menu.classList.toggle('opacity-100');
            menu.classList.toggle('pointer-events-none');
        }

        function toggleAudio() {
            const music = document.getElementById('bg-music');
            const btn = document.getElementById('audio-btn');
            
            if (music.paused) {
                music.play();
                btn.innerText = "AUDIO : ON";
                btn.classList.add('bg-white', 'text-black');
                btn.classList.remove('bg-black', 'text-white');
            } else {
                music.pause();
                btn.innerText = "AUDIO : OFF";
                btn.classList.add('bg-black', 'text-white');
                btn.classList.remove('bg-white', 'text-black');
            }
        }
    </script>
</body>
</html>