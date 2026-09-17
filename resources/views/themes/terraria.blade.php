<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TERRARIA-TODO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom Blue-Grey Scrollbar for the Settings Menu */
        .terraria-scroll::-webkit-scrollbar {
            width: 10px;
        }
        .terraria-scroll::-webkit-scrollbar-track {
            background: rgba(30, 43, 64, 0.8);
            border-radius: 4px;
        }
        .terraria-scroll::-webkit-scrollbar-thumb {
            background: rgba(62, 86, 126, 0.9);
            border: 2px solid #131b2b;
            border-radius: 4px;
        }

        /* Parallax Animation Engine (Animating X only to preserve Y height) */
        @keyframes slide-x {
            from { background-position-x: 0px; }
            to { background-position-x: -1920px; } 
        }

        .parallax-layer {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            background-repeat: repeat-x;
        }

        /* Adjusted Y-Positions */
        .layer-7 { background-image: url('/images/Background_7.png'); background-position-y: 20%; background-size: auto 60%; animation: slide-x 120s linear infinite; }
        .layer-8 { background-image: url('/images/Background_8.png'); background-position-y: 40%; background-size: auto 55%; animation: slide-x 90s linear infinite; }
        .layer-9 { background-image: url('/images/Background_9.png'); background-position-y: 60%; background-size: auto 50%; animation: slide-x 60s linear infinite; }
        .layer-10 { background-image: url('/images/Background_10.png'); background-position-y: 80%; background-size: auto 45%; animation: slide-x 45s linear infinite; }
        .layer-11 { background-image: url('/images/Background_11.png'); background-position-y: 100%; background-size: auto 40%; animation: slide-x 30s linear infinite; }

        /* Theme Menu Stacking Animation */
        .theme-btn {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.3s ease-out;
        }
        .theme-btn:nth-child(1) { transition-delay: 0.0s; }
        .theme-btn:nth-child(2) { transition-delay: 0.1s; }
        .theme-btn:nth-child(3) { transition-delay: 0.2s; }
        #theme-menu.menu-open .theme-btn {
            opacity: 1;
            transform: translateY(0);
        }
        #theme-menu.menu-open .theme-btn:nth-child(3) { transition-delay: 0.0s; }
        #theme-menu.menu-open .theme-btn:nth-child(2) { transition-delay: 0.1s; }
        #theme-menu.menu-open .theme-btn:nth-child(1) { transition-delay: 0.2s; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 font-['Terr'] text-white overflow-hidden tracking-wider bg-[#5890e0]">

    <!-- Parallax Background Stack -->
    <div class="fixed inset-0 -z-20">
        <div class="parallax-layer layer-7"></div>
        <div class="parallax-layer layer-8"></div>
        <div class="parallax-layer layer-9"></div>
        <div class="parallax-layer layer-10"></div>
        <div class="parallax-layer layer-11"></div>
    </div>

    <audio id="bg-music" loop>
        <source src="{{ asset('audio/terraria-music.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- Audio Toggle Button (Blocky & Translucent) -->
    <button onclick="toggleAudio()" id="audio-btn" class="fixed top-6 right-8 bg-[#32496a]/90 border-[3px] border-[#131b2b] text-white px-4 py-2 hover:bg-[#486090]/90 transition-colors z-50 cursor-pointer rounded-lg drop-shadow-[2px_2px_0px_#000]">
        Audio: Off
    </button>

    <!-- Main Settings Menu Container (Translucent & blockier corners) -->
    <div class="bg-[#2a3c5a]/85 w-full max-w-xl px-6 pb-6 pt-10 border-4 border-[#131b2b] rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.6)] relative z-10 mt-8 backdrop-blur-sm">
        
        <!-- Floating Overlapping Header -->
        <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-[#486090]/95 border-[3px] border-[#131b2b] rounded-lg px-8 py-2 shadow-md">
            <h1 class="text-3xl text-white drop-shadow-[2px_2px_0px_#000]">To-Do Menu</h1>
        </div>

        <!-- Add Task Form -->
        <div class="mb-4 bg-[#1e2b40]/80 p-3 rounded-lg border-[3px] border-[#131b2b]">
            <form action="{{ route('todo.store') }}" method="POST" class="flex gap-4">
                @csrf
                <input 
                    type="text" 
                    name="title" 
                    placeholder="New directive..." 
                    required
                    class="grow bg-transparent outline-none px-2 text-white placeholder-blue-300/60 drop-shadow-[1.5px_1.5px_0px_#000]"
                >
                <button type="submit" class="bg-[#32496a]/90 border-[3px] border-[#131b2b] hover:bg-[#486090]/90 px-4 py-1 transition-colors cursor-pointer rounded-md drop-shadow-[2px_2px_0px_#000]">
                    ADD
                </button>
            </form>
        </div>

        <!-- Task List -->
        <div class="space-y-2 max-h-80 overflow-y-auto terraria-scroll pr-2 mb-2">
            @foreach($todos as $todo)
                <div class="flex items-center justify-between bg-[#32496a]/85 p-3 rounded-lg border-[3px] border-[#1e2b40] hover:border-[#486090] transition-colors">
                    
                    <form action="{{ route('todo.update', $todo->id) }}" method="POST" class="flex items-center grow gap-4 justify-between mr-4">
                        @csrf
                        @method('PATCH')
                        
                        <span class="text-lg {{ $todo->status ? 'line-through text-gray-400' : 'text-white' }} drop-shadow-[2px_2px_0px_#000]">
                            {{ $todo->title }}
                        </span>

                        <!-- Custom Terraria "On/Off" Toggle (Blockier) -->
                        <label class="cursor-pointer relative flex items-center shrink-0">
                            <input type="checkbox" onChange="this.form.submit()" {{ $todo->status ? 'checked' : '' }} class="peer sr-only">
                            <!-- Off State -->
                            <div class="px-3 py-0.5 bg-[#585858]/90 border-[3px] border-[#131b2b] rounded-md text-sm peer-checked:hidden drop-shadow-[1.5px_1.5px_0px_#000]">Unfinished</div>
                            <!-- On State -->
                            <div class="px-3 py-0.5 bg-[#4aa02c]/90 border-[3px] border-[#131b2b] rounded-md text-sm hidden peer-checked:block text-white drop-shadow-[1.5px_1.5px_0px_#000]">Finished!</div>
                        </label>
                    </form>

                    <!-- Delete Button -->
                    <form action="{{ route('todo.destroy', $todo->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 flex items-center justify-center bg-[#b83838]/90 hover:bg-[#d84848]/90 border-[3px] border-[#131b2b] rounded-md text-white font-bold drop-shadow-[1px_1px_0px_#000] cursor-pointer transition-transform hover:scale-110">
                            ×
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Footer Stats -->
        <div class="text-center pt-2">
            <p class="text-[#8ba7d6] text-sm drop-shadow-[1.5px_1.5px_0px_#000]">
                Remaining : {{ $todos->where('status', false)->count() }}
            </p>
        </div>
    </div>

    <!-- Fall-up Menu Theme Switcher (Blocky) -->
    <div class="fixed bottom-6 right-8 z-50 flex flex-col items-end">
        <div id="theme-menu" class="mb-4 flex flex-col items-end gap-3 pointer-events-none">
            
            <a href="{{ route('theme.switch', 'miside') }}" class="theme-btn w-32 h-10 bg-[#32496a]/90 border-[3px] border-[#131b2b] text-white hover:bg-[#486090]/90 transition-colors flex items-center justify-center text-sm cursor-pointer rounded-lg drop-shadow-[2px_2px_0px_#000]">
                MISIDE
            </a>
            
            <a href="{{ route('theme.switch', 'default') }}" class="theme-btn w-32 h-10 bg-[#32496a]/90 border-[3px] border-[#131b2b] text-white hover:bg-[#486090]/90 transition-colors flex items-center justify-center text-sm cursor-pointer rounded-lg drop-shadow-[2px_2px_0px_#000]">
                DEFAULT
            </a>
            
            <a href="{{ route('theme.switch', 'ultrakill') }}" class="theme-btn w-32 h-10 bg-[#32496a]/90 border-[3px] border-[#131b2b] text-white hover:bg-[#486090]/90 transition-colors flex items-center justify-center text-sm cursor-pointer rounded-lg drop-shadow-[2px_2px_0px_#000]">
                ULTRAKILL
            </a>
            
        </div>

        <button onclick="toggleThemeMenu()" class="bg-[#486090]/95 border-[3px] border-[#131b2b] text-white hover:bg-[#5a78b0]/95 transition-colors px-6 py-2 cursor-pointer rounded-lg drop-shadow-[2px_2px_0px_#000]">
            THEMES
        </button>
    </div>

    <p class="fixed text-xs text-[#131b2b] font-bold bottom-3 left-5 z-10 opacity-70">
        CODESOME & GEMINI - 2026
    </p>

    <script>
        function toggleThemeMenu() {
            const menu = document.getElementById('theme-menu');
            menu.classList.toggle('menu-open');
            menu.classList.toggle('pointer-events-none');
        }

        function toggleAudio() {
            const music = document.getElementById('bg-music');
            const btn = document.getElementById('audio-btn');
            
            if (music.paused) {
                music.play();
                btn.innerText = "Audio: On";
            } else {
                music.pause();
                btn.innerText = "Audio: Off";
            }
        }
    </script>
</body>
</html>