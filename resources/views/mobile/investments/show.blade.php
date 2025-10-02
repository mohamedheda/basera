<!DOCTYPE html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>تفاصيل الفرصة الاستثمارية - InvestHub</title>
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
                position: relative;
            }

            .header h1 {
                font-size: 1.3rem;
                margin-bottom: 0.5rem;
            }

            .back-btn {
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: white;
                font-size: 1.2rem;
                cursor: pointer;
            }

            .container {
                padding: 1rem;
                max-width: 500px;
                margin: 0 auto;
                padding-bottom: 80px;
            }

            .investment-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                margin-bottom: 1rem;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .company-name {
                font-size: 1.5rem;
                font-weight: bold;
                color: #2c3e50;
                margin-bottom: 1rem;
            }

            .expected-return {
                color: #667eea;
                font-size: 1.2rem;
                font-weight: bold;
                margin-bottom: 1rem;
            }

            .return-tag {
                background: #e8f4fd;
                color: #2c3e50;
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                display: inline-block;
                margin-bottom: 1rem;
            }

            .price-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 0.75rem;
                padding: 0.75rem 0;
                border-bottom: 1px solid #e1e8ed;
            }

            .price-label {
                color: #7f8c8d;
                font-size: 0.9rem;
            }

            .price-value {
                color: #2c3e50;
                font-weight: 600;
                font-size: 1rem;
            }

            .about-section {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                margin-bottom: 1rem;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .section-title {
                font-size: 1.2rem;
                font-weight: bold;
                color: #2c3e50;
                margin-bottom: 1rem;
            }

            .market-tag {
                background: #e8f5e8;
                color: #2d5016;
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                display: inline-block;
                margin-bottom: 1rem;
            }

            .market-tag.american {
                background: #e3f2fd;
                color: #1565c0;
            }

            .description {
                color: #2c3e50;
                line-height: 1.6;
                font-size: 0.95rem;
            }

            .additional-info {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                margin-bottom: 1rem;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .info-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 0.75rem;
                padding: 0.75rem 0;
            }

            .info-row:last-child {
                margin-bottom: 0;
            }

            .info-label {
                color: #7f8c8d;
                font-size: 0.9rem;
            }

            .info-value {
                color: #2c3e50;
                font-weight: 600;
                font-size: 1rem;
            }

            .halal-badge {
                background: #e8f5e8;
                color: #27ae60;
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
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

                .investment-card,
                .about-section,
                .additional-info {
                    padding: 1rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="header">
            <button class="back-btn" onclick="goBack()">←</button>
            <h1>تفاصيل الفرصة الاستثمارية</h1>
        </div>

        <div class="container">
            <div id="investmentDetails">
                <div class="loading">جاري تحميل تفاصيل الفرصة...</div>
            </div>
        </div>

        <div class="bottom-nav">
            <a href="#" class="nav-item active">
                <div class="icon">🏠</div>
                <span>الفرص</span>
            </a>
            <a href="#" class="nav-item">
                <div class="icon">📊</div>
                <span>الباقات</span>
            </a>
            <a href="#" class="nav-item">
                <div class="icon">👤</div>
                <span>الحساب</span>
            </a>
        </div>

        <script>
            // Get investment ID from URL
            const investmentId = window.location.pathname.split('/').pop();

            // Load investment details on page load
            document.addEventListener('DOMContentLoaded', function() {
                loadInvestmentDetails();
            });

            function loadInvestmentDetails() {
                fetch(`/api/v1/investments/${investmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayInvestmentDetails(data.data);
                        } else {
                            showError('فشل في تحميل تفاصيل الفرصة الاستثمارية');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('حدث خطأ في الاتصال');
                    });
            }

            function displayInvestmentDetails(investment) {
                const container = document.getElementById('investmentDetails');

                container.innerHTML = `
                <div class="investment-card">
                    <div class="company-name">${investment.company_name}</div>
                    <div class="expected-return">+${investment.expected_return_percentage}%</div>
                    <div class="return-tag">عائد متوقع</div>
                    <div class="price-info">
                        <span class="price-label">السعر الحالي</span>
                        <span class="price-value">${formatPrice(investment.current_price, investment.market)}</span>
                    </div>
                    <div class="price-info">
                        <span class="price-label">سعر الدخول</span>
                        <span class="price-value">${formatPrice(investment.entry_price, investment.market)}</span>
                    </div>
                </div>

                <div class="about-section">
                    <div class="section-title">حول الفرصة</div>
                    <div class="market-tag ${investment.market === 'american' ? 'american' : ''}">
                        ${getMarketName(investment.market)}
                    </div>
                    <div class="description">${investment.description}</div>
                </div>

                <div class="additional-info">
                    <div class="section-title">معلومات إضافية</div>
                    <div class="info-row">
                        <span class="info-label">حلال</span>
                        <span class="halal-badge">${investment.is_halal ? 'نعم' : 'لا'}</span>
                    </div>
                </div>
            `;
            }

            function getMarketName(market) {
                const markets = {
                    'saudi': 'السوق السعودي',
                    'american': 'السوق الأمريكي',
                    'global': 'السوق العالمي'
                };
                return markets[market] || market;
            }

            function formatPrice(price, market) {
                if (market === 'american') {
                    return `$${price}`;
                } else {
                    return `${price} ريال سعودي`;
                }
            }

            function showError(message) {
                document.getElementById('investmentDetails').innerHTML =
                    `<div class="error">${message}</div>`;
            }

            function goBack() {
                window.history.back();
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
                        case 'الباقات':
                            window.location.href = '/subscriptions';
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

