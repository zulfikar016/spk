<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DSS Kurir GoTo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .login-header {
            background: #1a237e;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 30px;
        }
        .form-control:focus {
            border-color: #1a237e;
            box-shadow: 0 0 0 0.25rem rgba(26, 35, 126, 0.25);
        }
        .btn-login {
            background: #1a237e;
            color: white;
            padding: 10px 30px;
        }
        .btn-login:hover {
            background: #283593;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="login-header text-center">
                        <h3><i class="fas fa-truck-fast"></i> DSS Kurir GoTo</h3>
                        <p class="mb-0">Sistem Pendukung Keputusan Pemilihan Kurir Terbaik</p>
                    </div>
                    
                    <div class="p-5">
                        <!-- PERUBAHAN DISINI: Gunakan url('/login') bukan route('login') -->
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-login w-100">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        {{-- <div class="text-center">
                            <h6>Akun Demo:</h6>
                            <small class="text-muted d-block">Admin: admin@gotokurir.com / admin123</small>
                            <small class="text-muted d-block">Supervisor: supervisor@gotokurir.com / super123</small>
                            <small class="text-muted">Manager: manager@gotokurir.com / manager123</small>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>