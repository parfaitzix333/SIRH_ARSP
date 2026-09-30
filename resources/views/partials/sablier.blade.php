<style>
    /* ===== FULLSCREEN LOADER ===== */
    #loader {
        position: fixed;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, #f8f9ff, #e9ecff);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* ===== CONTAINER ===== */
    .loader-container {
        position: relative;
        width: 150px;
        height: 150px;
    }

    /* ===== LOGO ===== */
    .loader-logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        z-index: 3;
        animation: pulse 2s ease-in-out infinite;
    }

    /* ===== ROTATING RING ===== */
    .loader-ring {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid transparent;
        border-top: 5px solid #667eea;
        border-right: 5px solid #764ba2;
        animation: spin 1.2s linear infinite;
        position: absolute;
        top: 0;
        left: 0;
    }

    /* ===== GLOW EFFECT ===== */
    .loader-glow {
        position: absolute;
        width: 120px;
        height: 120px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.4), transparent 70%);
        filter: blur(15px);
        animation: glowPulse 2s ease-in-out infinite;
        z-index: 1;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: translate(-50%, -50%) scale(1);
        }

        50% {
            transform: translate(-50%, -50%) scale(1.1);
        }
    }

    @keyframes glowPulse {

        0%,
        100% {
            opacity: 0.5;
            transform: translate(-50%, -50%) scale(1);
        }

        50% {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1.3);
        }
    }

    /* ===== FADE OUT ===== */
    .fade-out {
        opacity: 0;
        transition: opacity 0.6s ease;
    }
</style>
</head>

<body>

    <!-- ===== LOADER ===== -->
    <div id="loader">
        <div class="loader-container">
            <div class="loader-glow"></div>
            <div class="loader-ring"></div>
            <img src="{{ asset('image/logo.jpeg') }}" class="loader-logo">
        </div>
    </div>

    <!-- ===== SCRIPT ===== -->
    <script>
        window.addEventListener("load", function() {
            const loader = document.getElementById("loader");
            const content = document.getElementById("content");

            // minimum 2 secondes
            setTimeout(() => {
                loader.classList.add("fade-out");

                setTimeout(() => {
                    loader.style.display = "none";
                    content.classList.remove("d-none");
                }, 600);

            }, 2000);
        });
    </script>

</body>

</html>
