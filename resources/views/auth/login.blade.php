<x-guest-layout>
    <style>
        /* 🌌 Rainy Green Background Animation (Uiverse) */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden; /* 🚫 Hilangkan scroll di seluruh body */
            font-family: 'Poppins', sans-serif;
            touch-action: none; /* 🚫 Mencegah scroll/drag di layar sentuh */
        }

        .rain-bg {
            position: absolute;
            inset: 0;
        }

        .rain-bg::before {
            content: "";
            position: absolute;
            inset: -145%;
            rotate: -45deg;
            background: #000;
            background-image:
                radial-gradient(4px 100px at 0px 235px, #0f0, #0000),
                radial-gradient(4px 100px at 300px 235px, #0f0, #0000),
                radial-gradient(1.5px 1.5px at 150px 117.5px, #0f0 100%, #0000 150%),
                radial-gradient(4px 100px at 0px 252px, #0f0, #0000),
                radial-gradient(4px 100px at 300px 252px, #0f0, #0000),
                radial-gradient(1.5px 1.5px at 150px 126px, #0f0 100%, #0000 150%),
                radial-gradient(4px 100px at 0px 150px, #0f0, #0000),
                radial-gradient(4px 100px at 300px 150px, #0f0, #0000),
                radial-gradient(1.5px 1.5px at 150px 75px, #0f0 100%, #0000 150%);
            background-size: 300px 235px;
            animation: hi 150s linear infinite;
        }

        @keyframes hi {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 0 7000px;
            }
        }

        /* 🌫️ Container tengah */
        .container {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* ⬆️ Pastikan tinggi 1 layar penuh */
            width: 100%;
            overflow: hidden;
        }

        /* 💚 Card Login Aesthetic */
        .card {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 25px;
            width: 340px;
            min-height: 470px;
            background: rgba(34, 197, 94, 0.12);
            box-shadow:
                0 8px 25px rgba(0, 0, 0, 0.25),
                inset 0 0 20px rgba(34, 197, 94, 0.3);
            border: 1px solid rgba(34, 197, 94, 0.3);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        /* 🖼️ Logo */
        .logo {
            width: 85px;
            height: 85px;
            object-fit: contain;
            border-radius: 50%;
            background: #fff;
            padding: 8px;
            box-shadow: 0 0 15px rgba(34, 197, 94, 0.6);
        }

        /* ✨ Judul dan teks */
        .welcome-title {
            font-weight: 700;
            font-size: 1.2rem;
            color: #00ff6a;
            text-shadow: 0 0 8px rgba(0, 255, 100, 0.8);
            margin-bottom: 0.25rem;
        }

        .welcome-subtitle {
            font-size: 0.9rem;
            color: #d4d4d4;
            margin-bottom: 1rem;
        }

        /* 🧾 Input box */
        .inputBox {
            position: relative;
            width: 250px;
        }

        .inputBox input {
            width: 100%;
            padding: 10px;
            outline: none;
            border: none;
            color: #00ff88;
            font-size: 1em;
            background: transparent;
            border-left: 2px solid #00ff88;
            border-bottom: 2px solid #00ff88;
            transition: 0.2s;
            border-bottom-left-radius: 8px;
        }

        .inputBox span {
            position: absolute;
            left: 0;
            transform: translateY(-4px);
            margin-left: 10px;
            padding: 10px;
            pointer-events: none;
            font-size: 12px;
            color: #a3a3a3;
            text-transform: uppercase;
            transition: 0.4s;
            letter-spacing: 3px;
        }

        .inputBox input:valid~span,
        .inputBox input:focus~span {
            transform: translateX(120px) translateY(-15px);
            font-size: 0.75em;
            padding: 5px 10px;
            background: #00ff6a;
            color: #000;
            border-radius: 5px;
            letter-spacing: 0.1em;
        }

        .inputBox input:valid,
        .inputBox input:focus {
            border: 2px solid #00ff6a;
            border-radius: 8px;
        }

        /* 🔘 Tombol Login */
        .enter {
            height: 45px;
            width: 130px;
            border-radius: 8px;
            border: 2px solid #00ff6a;
            cursor: pointer;
            background-color: transparent;
            transition: 0.4s;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 600;
            color: #00ff6a;
            letter-spacing: 2px;
        }

        .enter:hover {
            background-color: #00ff6a;
            color: #000;
            box-shadow: 0 0 15px rgba(0, 255, 100, 0.8);
        }

        /* 🔗 Lupa Password */
        .forgot-link {
            font-size: 0.8em;
            color: #a3a3a3;
            text-decoration: underline;
            cursor: pointer;
        }

        .forgot-link:hover {
            color: #00ff88;
        }

        /* 📱 Responsif mobile */
        @media (max-width: 480px) {
            .card {
                width: 90%;
                min-height: 420px;
                padding: 1.5rem 1rem;
            }
            .inputBox {
                width: 220px;
            }
        }
    </style>

    <div class="rain-bg"></div>

    <div class="container">
        <div class="card">
            <img src="{{ asset('images/Logo-IAIT.png') }}" alt="Logo" class="logo">
            <div>
                <h2 class="welcome-title">Selamat Datang di Website SIPANDA</h2>
                <p class="welcome-subtitle">Silahkan login untuk melanjutkan</p>
            </div>

            <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; align-items: center; gap: 25px;">
                @csrf
                <div class="inputBox">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <span>Email</span>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <div class="inputBox">
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                    <span>Password</span>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        {{ __('Lupa kata sandi?') }}
                    </a>
                @endif

                <button type="submit" class="enter">Masuk</button>
            </form>
        </div>
    </div>
</x-guest-layout>
