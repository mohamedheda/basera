<!DOCTYPE html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>تسجيل الدخول - InvestHub</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                direction: rtl;
            }

            .login-container {
                background: white;
                padding: 2rem;
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                width: 90%;
                max-width: 400px;
                text-align: center;
            }

            .logo {
                margin-bottom: 2rem;
            }

            .logo h1 {
                color: #2c3e50;
                font-size: 2rem;
                font-weight: bold;
                margin-bottom: 0.5rem;
            }

            .logo .subtitle {
                color: #7f8c8d;
                font-size: 0.9rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
                text-align: right;
            }

            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                color: #2c3e50;
                font-weight: 600;
            }

            .form-group input {
                width: 100%;
                padding: 12px 15px;
                border: 2px solid #e1e8ed;
                border-radius: 10px;
                font-size: 1rem;
                transition: border-color 0.3s;
            }

            .form-group input:focus {
                outline: none;
                border-color: #667eea;
            }

            .password-field {
                position: relative;
            }

            .password-toggle {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                color: #7f8c8d;
                font-size: 1.2rem;
            }

            .login-btn {
                width: 100%;
                padding: 15px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 1.1rem;
                font-weight: 600;
                cursor: pointer;
                transition: transform 0.2s;
                margin-bottom: 1rem;
            }

            .login-btn:hover {
                transform: translateY(-2px);
            }

            .forgot-password {
                color: #667eea;
                text-decoration: none;
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
                display: inline-block;
            }

            .divider {
                display: flex;
                align-items: center;
                margin: 1.5rem 0;
                color: #7f8c8d;
            }

            .divider::before,
            .divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background: #e1e8ed;
            }

            .divider span {
                padding: 0 1rem;
            }

            .google-btn {
                width: 100%;
                padding: 15px;
                background: white;
                border: 2px solid #e1e8ed;
                border-radius: 10px;
                font-size: 1rem;
                cursor: pointer;
                transition: border-color 0.3s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }

            .google-btn:hover {
                border-color: #667eea;
            }

            .google-icon {
                width: 20px;
                height: 20px;
            }

            .signup-link {
                color: #667eea;
                text-decoration: none;
                font-size: 0.9rem;
                margin-top: 1rem;
                display: inline-block;
            }

            .footer {
                position: fixed;
                bottom: 10px;
                left: 10px;
                color: rgba(255, 255, 255, 0.8);
                font-size: 0.8rem;
            }

            @media (max-width: 480px) {
                .login-container {
                    margin: 1rem;
                    padding: 1.5rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="login-container">
            <div class="logo">
                <h1>InvestHub</h1>
                <p class="subtitle">تطبيق الاستثمار الذكي</p>
            </div>

            <form id="loginForm">
                <div class="form-group">
                    <label for="phone">رقم الجوال</label>
                    <input type="tel" id="phone" name="phone" placeholder="أدخل رقم الجوال" required>
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" placeholder="أدخل كلمة المرور" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">👁️</button>
                    </div>
                </div>

                <button type="submit" class="login-btn">تسجيل الدخول</button>
                <a href="#" class="forgot-password">هل نسيت كلمة المرور ؟</a>

                <div class="divider">
                    <span>أو</span>
                </div>

                <button type="button" class="google-btn" onclick="loginWithGoogle()">
                    <span class="google-icon">G</span>
                    تسجيل الدخول باستخدام جوجل
                </button>

                <a href="#" class="signup-link">ليس لديك حساب ؟ إنشاء حساب</a>
            </form>
        </div>

        <div class="footer">
            Made with ❤️
        </div>

        <script>
            function togglePassword() {
                const passwordField = document.getElementById('password');
                const toggleBtn = document.querySelector('.password-toggle');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    toggleBtn.textContent = '🙈';
                } else {
                    passwordField.type = 'password';
                    toggleBtn.textContent = '👁️';
                }
            }

            function loginWithGoogle() {
                // Google login implementation
                console.log('Google login clicked');
            }

            document.getElementById('loginForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const phone = document.getElementById('phone').value;
                const password = document.getElementById('password').value;

                // Basic validation
                if (!phone || !password) {
                    alert('يرجى ملء جميع الحقول');
                    return;
                }

                // API call to login
                fetch('/api/v1/auth/sign/in', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            phone: phone,
                            password: password
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Store token and redirect
                            localStorage.setItem('token', data.data.token);
                            window.location.href = '/dashboard';
                        } else {
                            alert(data.message || 'حدث خطأ في تسجيل الدخول');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ في الاتصال');
                    });
            });

            // Handle forgot password link
            document.querySelector('.forgot-password').addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '/forgot-password';
            });

            // Handle signup link
            document.querySelector('.signup-link').addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '/register';
            });
        </script>
    </body>

</html>

