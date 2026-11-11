<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LibSys SMK Budi Bakti Ciwidey</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body>

    <!-- Container utama untuk memposisikan card di tengah layar -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-5 col-lg-4">
            
            <!-- Card Form Login -->
            <div class="card shadow-sm p-4 border-0 rounded-4 bg-white">
                
                <!-- Logo & Judul -->
                <div class="text-center mb-4">
                    <img src="{{ asset('Images/Logo_LibSys.png') }}" alt="Logo LibSys" style="width: 80px; height: 80px; object-fit: contain;">
                    <h4 class="fw-bold mt-3 text-dark">Selamat Datang!</h4>
                    <p class="text-muted small">Silahkan masukkan akun Anda untuk masuk.</p>
                </div>

                <!-- Session Status / Error -->
                @if(session('status'))
                    <div class="alert alert-success small py-2">{{ session('status') }}</div>
                @endif

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email / Akun -->
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-secondary">Email / Akun</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                   <div class="mb-3">
    <label for="password" class="form-label small fw-semibold text-secondary">Password</label>
    <div class="input-group">
        <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-lock"></i></span>
        
        <!-- Input password diberi id="password" -->
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="********" required>
        
        <!-- Tambahan Tombol Mata untuk Lihat/Sembunyikan Password -->
        <button class="btn btn-outline-secondary border" type="button" id="toggle-password" onclick="togglePasswordVisibility()">
            <i class="fa-solid fa-eye" id="eye-icon"></i>
        </button>
    </div>
    @error('password')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<!-- Remember Me & Lupa Password -->
<div class="d-flex justify-content-between align-items-center mb-4 small">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label text-muted" for="remember">Ingat Saya</label>
    </div>
    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="text-decoration-none text-primary fw-semibold">Lupa Password?</a>
    @endif
</div>

                    <!-- Tombol Masuk -->
                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold shadow-sm">
                        Masuk Sistem
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
function togglePasswordVisibility() {
    let passwordInput = document.getElementById('password');
    let eyeIcon = document.getElementById('eye-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text'; // Ubah jadi teks biasa (password terlihat)
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash'); // Ubah ikon mata menjadi dicoret
    } else {
        passwordInput.type = 'password'; // Ubah kembali menjadi titik-titik
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye'); // Kembalikan ikon mata normal
    }
}
</script>
</body>
</html>