<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katana - The True Cut</title>

    {{-- Custom Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'] )

    <style>
        /* Basic Styles */
        body { background-color: #000; color: #fff; font-family: 'Orbitron', sans-serif; overflow: hidden; }
        .text-glow { text-shadow: 0 0 10px rgba(239, 68, 68, 0.6), 0 0 25px rgba(239, 68, 68, 0.4); }

        /* Vanta Canvas */
        #vanta-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; }

        /* Main Content Area */
        .main-content {
            position: relative;
            z-index: 10;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        header { flex-shrink: 0; }

        /* Hero Section */
        .hero {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        /* The "Cut" Animation Overlay */
        #cut-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 100;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.1s 0.8s; /* Fade in after animation starts */
        }

        .cut-pane {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('data:image/png;base64,...'); /* Your background image data */
            background-size: cover;
            background-position: center;
            transition: clip-path 0.8s cubic-bezier(0.77, 0, 0.175, 1);
        }

        #top-pane {
            clip-path: polygon(0 0, 100% 0, 100% 0, 0 0); /* Collapsed at the top */
        }
        #bottom-pane {
            clip-path: polygon(0 100%, 100% 100%, 100% 100%, 0 100%); /* Collapsed at the bottom */
        }

        /* The "Slash" effect */
        #slash {
            position: fixed;
            top: 50%;
            left: -25%;
            width: 150%;
            height: 5px;
            background: linear-gradient(to right, transparent, white, transparent);
            box-shadow: 0 0 15px 5px #fff, 0 0 30px 10px #ef4444;
            transform: translateY(-50%) rotate(-25deg) scaleX(0);
            transition: transform 0.3s ease-out;
            z-index: 110;
        }

        /* Animation Trigger State */
        body.cutting #cut-overlay { opacity: 1; transition: opacity 0.1s; }
        body.cutting #slash { transform: translateY(-50%) rotate(-25deg) scaleX(1); }
        body.cutting #top-pane { clip-path: polygon(0 0, 100% 0, 100% 45%, 0 55%); }
        body.cutting #bottom-pane { clip-path: polygon(0 100%, 100% 100%, 100% 55%, 0 45%); }
    </style>
</head>
<body class="antialiased">

    <div id="vanta-bg"></div>

    <div class="main-content">
        <header class="p-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <span class="text-2xl font-black text-red-500 tracking-widest">KATANA</span>
            </a>
            <div>
                <a href="{{ route('login') }}" id="login-link" class="px-5 py-2 text-lg font-bold border-2 border-red-500 rounded-md hover:bg-red-500 transition-colors">
                    Log In
                </a>
            </div>
        </header>

        <div class="hero">
            <div>
                <h1 class="text-8xl text-white text-glow">KATANA</h1>
                <p class="mt-4 text-xl text-gray-400">Unleash Your Digital Arsenal</p>

                {{-- The button is now part of the main view --}}
                <div class="mt-20">
                    <button id="cut-button" class="px-8 py-4 text-2xl font-bold border-4 border-red-500 rounded-lg text-red-500 hover:bg-red-500 hover:text-black transition-all duration-300 transform hover:scale-110">
                        ENTER
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- The "Cut" Animation Elements --}}
    <div id="cut-overlay">
        <div id="slash"></div>
        {{-- These panes will now capture the screen and split it --}}
        <div id="top-pane" class="cut-pane"></div>
        <div id="bottom-pane" class="cut-pane"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>
    <script>
        // Initialize Vanta.js
        VANTA.NET({
            el: "#vanta-bg",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            scale: 1.00,
            scaleMobile: 1.00,
            color: 0xef4444,
            backgroundColor: 0x0
        } );

        // The TRUE "Cut" Animation Logic
        const cutButton = document.getElementById('cut-button');
        const loginLink = document.getElementById('login-link');
        const topPane = document.getElementById('top-pane');
        const bottomPane = document.getElementById('bottom-pane');

        cutButton.addEventListener('click', (e) => {
            e.preventDefault();

            // 1. Take a "screenshot" of the current page
            html2canvas(document.querySelector(".main-content")).then(canvas => {
                const imageUrl = canvas.toDataURL();

                // 2. Set the screenshot as the background for the splitting panes
                topPane.style.backgroundImage = `url(${imageUrl})`;
                bottomPane.style.backgroundImage = `url(${imageUrl})`;

                // 3. Trigger the animation
                document.body.classList.add('cutting');

                // 4. Redirect after the animation
                setTimeout(() => {
                    window.location.href = loginLink.href;
                }, 1500); // Wait for the full animation
            });
        });
    </script>
</body>
</html>
