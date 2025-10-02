<!DOCTYPE html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>الباقات - InvestHub</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: #f8f9fa;
                direction: rtl;
            }

            .header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 1rem;
                text-align: center;
            }

            .header h1 {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }

            .container {
                padding: 1rem;
                max-width: 500px;
                margin: 0 auto;
                padding-bottom: 80px;
            }

            .package-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                margin-bottom: 1rem;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                position: relative;
                transition: transform 0.2s;
            }

            .package-card:hover {
                transform: translateY(-2px);
            }

            .package-card.popular {
                border: 2px solid #667eea;
            }

            .popular-badge {
                position: absolute;
                top: -10px;
                right: 1rem;
                background: #667eea;
                color: white;
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .package-header {
                display: flex;
                align-items: center;
                margin-bottom: 1rem;
            }

            .package-icon {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                margin-left: 1rem;
            }

            .package-info {
                flex: 1;
            }

            .package-name {
                font-size: 1.3rem;
                font-weight: bold;
                color: #2c3e50;
                margin-bottom: 0.25rem;
            }

            .package-description {
                color: #7f8c8d;
                font-size: 0.9rem;
            }

            .package-price {
                font-size: 2rem;
                font-weight: bold;
                color: #2c3e50;
                margin-bottom: 0.5rem;
            }

            .package-currency {
                font-size: 1rem;
                color: #7f8c8d;
                font-weight: normal;
            }

            .features {
                margin-bottom: 1.5rem;
            }

            .feature {
                display: flex;
                align-items: center;
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
                color: #2c3e50;
            }

            .feature::before {
                content: '✓';
                color: #27ae60;
                font-weight: bold;
                margin-left: 0.5rem;
                font-size: 1rem;
            }

            .choose-btn {
                width: 100%;
                padding: 12px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: transform 0.2s;
            }

            .choose-btn:hover {
                transform: translateY(-1px);
            }

            .choose-btn:disabled {
                background: #bdc3c7;
                cursor: not-allowed;
                transform: none;
            }

            .loading {
                text-align: center;
                padding: 2rem;
                color: #7f8c8d;
            }

            .error {
                text-align: center;
                padding: 2rem;
                color: #e74c3c;
                background: white;
                border-radius: 10px;
                margin: 1rem;
            }

            .bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                border-top: 1px solid #e1e8ed;
                display: flex;
                justify-content: space-around;
                padding: 0.5rem 0;
            }

            .nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
                color: #7f8c8d;
                font-size: 0.8rem;
                padding: 0.5rem;
                transition: color 0.3s;
            }

            .nav-item.active {
                color: #667eea;
            }

            .nav-item .icon {
                font-size: 1.2rem;
                margin-bottom: 0.25rem;
            }

            @media (max-width: 480px) {
                .container {
                    padding: 0.5rem;
                }

                .package-card {
                    padding: 1rem;
                }

                .package-price {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="header">
            <h1>الباقات</h1>
            <p class="subtitle">اختر الباقة المناسبة لك</p>
        </div>

        <div class="container">
            <div id="packagesContainer">
                <div class="loading">جاري تحميل الباقات...</div>
            </div>
        </div>

        <div class="bottom-nav">
            <a href="#" class="nav-item">
                <div class="icon">🏠</div>
                <span>الفرص</span>
            </a>
            <a href="#" class="nav-item active">
                <div class="icon">📊</div>
                <span>الباقات</span>
            </a>
            <a href="#" class="nav-item">
                <div class="icon">👤</div>
                <span>الحساب</span>
            </a>
        </div>

        <script>
            let userActiveSubscription = null;

            // Load packages on page load
            document.addEventListener('DOMContentLoaded', function() {
                loadPackages();
                checkActiveSubscription();
            });

            function loadPackages() {
                fetch('/api/v1/subscriptions/packages')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayPackages(data.data);
                        } else {
                            showError('فشل في تحميل الباقات');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('حدث خطأ في الاتصال');
                    });
            }

            function checkActiveSubscription() {
                const token = localStorage.getItem('token');
                if (!token) return;

                fetch('/api/v1/subscriptions/active', {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            userActiveSubscription = data.data;
                        }
                    })
                    .catch(error => {
                        console.error('Error checking subscription:', error);
                    });
            }

            function displayPackages(packages) {
                const container = document.getElementById('packagesContainer');

                if (packages.length === 0) {
                    container.innerHTML = '<div class="error">لا توجد باقات متاحة</div>';
                    return;
                }

                container.innerHTML = packages.map(package => `
                <div class="package-card ${package.is_popular ? 'popular' : ''}">
                    ${package.is_popular ? '<div class="popular-badge">الأكثر شعبية</div>' : ''}
                    
                    <div class="package-header">
                        <div class="package-icon">⏰</div>
                        <div class="package-info">
                            <div class="package-name">${package.name}</div>
                            <div class="package-description">${package.description}</div>
                        </div>
                    </div>

                    <div class="package-price">
                        ${package.price.toLocaleString()}
                        <span class="package-currency">${package.currency}</span>
                    </div>

                    <div class="features">
                        ${package.features ? package.features.map(feature => 
                            `<div class="feature">${feature}</div>`
                        ).join('') : ''}
                    </div>

                    <button class="choose-btn" 
                            onclick="choosePackage(${package.id})"
                            ${userActiveSubscription && userActiveSubscription.subscription_package_id === package.id ? 'disabled' : ''}>
                        ${userActiveSubscription && userActiveSubscription.subscription_package_id === package.id ? 'مشترك حالياً' : 'اختر الباقة'}
                    </button>
                </div>
            `).join('');
            }

            function choosePackage(packageId) {
                const token = localStorage.getItem('token');
                if (!token) {
                    alert('يجب تسجيل الدخول أولاً');
                    window.location.href = '/login';
                    return;
                }

                if (userActiveSubscription) {
                    alert('لديك اشتراك نشط بالفعل');
                    return;
                }

                if (confirm('هل تريد الاشتراك في هذه الباقة؟')) {
                    subscribeToPackage(packageId);
                }
            }

            function subscribeToPackage(packageId) {
                const token = localStorage.getItem('token');

                fetch('/api/v1/subscriptions/subscribe', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + token
                        },
                        body: JSON.stringify({
                            package_id: packageId,
                            payment_method: 'online',
                            transaction_id: 'TXN_' + Date.now()
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('تم الاشتراك بنجاح!');
                            checkActiveSubscription();
                            loadPackages(); // Refresh packages to update button states
                        } else {
                            alert(data.message || 'فشل في الاشتراك');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ في الاتصال');
                    });
            }

            function showError(message) {
                document.getElementById('packagesContainer').innerHTML =
                    `<div class="error">${message}</div>`;
            }

            // Navigation
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all items
                    document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));

                    // Add active class to clicked item
                    this.classList.add('active');

                    // Handle navigation
                    const text = this.querySelector('span').textContent;
                    switch (text) {
                        case 'الفرص':
                            window.location.href = '/investments';
                            break;
                        case 'الحساب':
                            window.location.href = '/profile';
                            break;
                    }
                });
            });
        </script>
    </body>

</html>

