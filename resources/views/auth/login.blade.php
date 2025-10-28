<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIPANDA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-ka0m/5R..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3498db, #2ecc71);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .login-card {
            position: relative;
            z-index: 1;
            width: 320px;
            padding: 1.8rem 1.5rem 2rem;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            text-align: center;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-logo {
            width: 75px;
            height: 75px;
            object-fit: contain;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
            margin: 0 auto 15px;
            display: block;
        }

        .welcome-title {
            font-size: 1.1rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff, #e6f7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 6px;
        }

        .welcome-subtitle {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1.3rem;
        }

        /* Input dengan icon di kanan */
        .inputBox {
            margin-bottom: 1rem;
            width: 100%;
            text-align: left;
            position: relative;
        }

        .inputBox label {
            display: block;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 6px;
            font-weight: 500;
        }

        .inputBox input {
            display: block;
            width: 100%;
            padding: 10px 35px 10px 12px;
            /* space kanan untuk icon */
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0);
            /* transparan selalu */
            color: #fff;
            font-size: 0.85rem;
            transition: 0.3s ease;
            box-sizing: border-box;
        }

        .inputBox input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .inputBox input:focus {
            border-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
            outline: none;
            background: rgba(255, 255, 255, 0);
            /* tetap transparan */
        }

        /* Icon di input kanan, tengah vertikal */
        .inputBox i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: 0.3s;
        }

        .inputBox i:hover {
            color: #fff;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
        }

        .login-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }

        .forgot-link {
            display: inline-block;
            margin-top: 1rem;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: underline;
        }

        .forgot-link:hover {
            color: #fff;
        }

        .text-red-500 {
            color: #ff6b6b;
            font-size: 0.75rem;
            margin-top: 5px;
        }

        @media (max-width: 480px) {
            .login-card {
                width: 85%;
                padding: 1.5rem 1.2rem;
            }
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            /* 🔹 biar icon vertikal center */
        }

        .input-wrapper input {
            width: 100%;
            padding-right: 35px;
            /* beri ruang untuk icon */
            height: 40px;
            box-sizing: border-box;
        }

        .input-wrapper i {
            position: absolute;
            right: 10px;
            font-size: 16px;
            cursor: pointer;
            /* Gradient hijau lebih hidup */
            background: linear-gradient(135deg, #2ecc71, #27ae60, #1abc9c, #16a085);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <img src="{{ asset('images/Logo-IAIT.png') }}" alt="Logo" class="login-logo">
        <h2 class="welcome-title">Selamat Datang di Website SIPANDA</h2>
        <p class="welcome-subtitle">Silahkan login untuk melanjutkan</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="inputBox">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input id="email" type="email" name="email" placeholder="Masukkan email anda"
                        value="{{ old('email') }}" required autofocus autocomplete="username">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="text-red-500"></div>
            </div>

            <div class="inputBox">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input id="password" type="password" name="password" placeholder="Masukkan password" required
                        autocomplete="current-password">
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>
                <div class="text-red-500"></div>
            </div>

            <button type="submit" class="login-btn">Masuk</button>

            <div>
                <a class="forgot-link" href="{{ route('password.request') }}">Lupa kata sandi?</a>
            </div>
        </form>

    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
