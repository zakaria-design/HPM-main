<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

{{-- bootsrap icon --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* Body dan background gradasi */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #1e3a8a 0%, #000000 35%, #ff7f50 70%, #000000 100%);
}

    /* Card login */
.login-card {
    background-color: rgba(255, 255, 255, 0.95);
    padding: 2rem;
    border-radius: 0.5rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    width: 100%;
    max-width: 400px;
}s

    .login-card h1 {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    /* Form elements */
    .login-card label {
        display: block;
        margin-bottom: 0.3rem;
        font-weight: bold;
    }

    .login-card input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    /* Border oranye saat diketik */
    .login-card input:focus {
        outline: none;
        border-color: #ff7f50; /* oranye */
        box-shadow: 0 0 5px rgba(255,127,80,0.5);
    }

    /* Tombol oranye */
    .login-card button {
        width: 100%;
        padding: 0.6rem;
        background-color: #ff7f50; /* oranye */
        color: white;
        border: none;
        border-radius: 0.25rem;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .login-card button:hover {
        background-color: #e6733f; /* lebih gelap sedikit saat hover */
    }

    .password-wrapper {
    position: relative;
}

.password-wrapper input {
    width: 100%;
    padding-right: 2.5rem; /* ruang untuk ikon mata */
}

.password-wrapper .toggle-password {
    position: absolute;
    top: 50%;
    right: 0.75rem;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
    font-size: 1.1rem;
}

    /* Error messages */
    .alert {
        background-color: #f8d7da;
        color: #842029;
        padding: 0.75rem 1rem;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
        .login-card {
            padding: 1.5rem;
        }

        .login-card input, .login-card button {
            font-size: 0.95rem;
        }
    }
</style>
</head>
<body>

<div class="login-card">
    <h1 class="text-center">Login</h1>

    {{-- memanggil pesan eror di controller --}}
    @if($errors->any())
        <div class="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>     
                @endforeach
            </ul>
        </div>
    @endif

<form action="" method="POST">
    @csrf

    <div class="mb-3">
        <label for="user_id">User ID</label>
        <input type="text" name="user_id" value="{{ old('user_id') }}" class="form-control mb-3" placeholder="masukan ID">
    </div>
        
    <div class="mb-3 password-wrapper" style="position: relative;">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="passwordInput" name="password"
            placeholder="Masukkan Password" style="padding-right: 2.5rem; height: 2.5rem;">
        <i class="bi bi-eye toggle-password"
        id="togglePassword"
        style="
            position: absolute;
            top: 72%;
            right: 0.75rem;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.25rem;
            color: #6c757d;">
        </i>
    </div>




    <button type="submit" name="submit" id="loginBtn" class="btn btn-primary w-100">
        <span class="btn-text">Login</span>
        <span class="spinner-border spinner-border-sm text-light d-none" role="status" aria-hidden="true"></span>
    </button>
</form>
</div>

<script>
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('passwordInput');
const loginForm = document.getElementById('loginForm');
const loginBtn = document.getElementById('loginBtn');
const btnText = loginBtn.querySelector('.btn-text');
const spinner = loginBtn.querySelector('.spinner-border');

// Toggle password
togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
});

// Loading effect
loginForm.addEventListener('submit', function(e) {
    btnText.classList.add('d-none');
    spinner.classList.remove('d-none');
    loginBtn.disabled = true;
});
</script>

</body>
</html>
