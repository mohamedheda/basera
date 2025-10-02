<!DOCTYPE html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>الفرص الاستثمارية - InvestHub</title>
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
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }

            .header .subtitle {
                font-size: 0.9rem;
                opacity: 0.9;
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
            }

            .investment-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                margin-bottom: 1rem;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s;
            }

            .investment-card:hover {
                transform: translateY(-2px);
            }

            .card-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .market-tag {
                background: #e8f5e8;
                color: #2d5016;
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .market-tag.american {
                background: #e3f2fd;
                color: #1565c0;
            }

            .company-name {
                font-size: 1.3rem;
                font-weight: bold;
                color: #2c3e50;
                margin-bottom: 1rem;
            }

            .price-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
            }

            .price-label {
                color: #7f8c8d;
            }

            .price-value {
                color: #2c3e50;
                font-weight: 600;
            }

            .expected-return {
                color: #27ae60;
                font-weight: bold;
                font-size: 1.1rem;
            }

            .details-btn {
                width: 100%;
                padding: 12px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                margin-top: 1rem;
                transition: transform 0.2s;
            }

            .details-btn:hover {
                transform: translateY(-1px);
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

            .search-bar {
                background: white;
                border-radius: 10px;
                padding: 1rem;
                margin-bottom: 1rem;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .search-input {
                width: 100%;
                padding: 12px 15px;
                border: 2px solid #e1e8ed;
                border-radius: 10px;
                font-size: 1rem;
                transition: border-color 0.3s;
            }

            .search-input:focus {
                outline: none;
                border-color: #667eea;
            }

            @media (max-width: 480px) {
                .container {
                    padding: 0.5rem;
                    padding-bottom: 80px;
                }

                .investment-card {
                    padding: 1rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="header">
            <button class="back-btn" onclick="goBack()">←</button>
            <h1>الفرص الاستثمارية</h1>
            <p class="subtitle">اكتشف أفضل الفرص الاستثمارية المناسبة لك</p>
        </div>

        <div class="container">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="ابحث عن الفرص الاستثمارية..." id="searchInput">
            </div>

            <div id="investmentsContainer">
                <div class="loading">جاري تحميل الفرص الاستثمارية...</div>
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
            let allInvestments = [];

            // Load investments on page load
            document.addEventListener('DOMContentLoaded', function() {
                loadInvestments();
            });

            function loadInvestments() {
                fetch('/api/v1/investments')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            allInvestments = data.data.data;
                            displayInvestments(allInvestments);
                        } else {
                            showError('فشل في تحميل الفرص الاستثمارية');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('حدث خطأ في الاتصال');
                    });
            }

            function displayInvestments(investments) {
                const container = document.getElementById('investmentsContainer');

                if (investments.length === 0) {
                    container.innerHTML = '<div class="error">لا توجد فرص استثمارية متاحة</div>';
                    return;
                }

                container.innerHTML = investments.map(investment => `
                <div class="investment-card" onclick="showInvestmentDetails(${investment.id})">
                    <div class="card-header">
                        <div class="market-tag ${investment.market === 'american' ? 'american' : ''}">
                            ${getMarketName(investment.market)}
                        </div>
                    </div>
                    <div class="company-name">${investment.company_name}</div>
                    <div class="price-info">
                        <span class="price-label">السعر الحالي:</span>
                        <span class="price-value">${formatPrice(investment.current_price, investment.market)}</span>
                    </div>
                    <div class="price-info">
                        <span class="price-label">سعر الدخول:</span>
                        <span class="price-value">${formatPrice(investment.entry_price, investment.market)}</span>
                    </div>
                    <div class="price-info">
                        <span class="price-label">العائد المتوقع:</span>
                        <span class="expected-return">+${investment.expected_return_percentage}%</span>
                    </div>
                    <button class="details-btn">تفاصيل</button>
                </div>
            `).join('');
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
                    return `${price} ر.س`;
                }
            }

            function showInvestmentDetails(id) {
                window.location.href = `/investment/${id}`;
            }

            function showError(message) {
                document.getElementById('investmentsContainer').innerHTML =
                    `<div class="error">${message}</div>`;
            }

            function goBack() {
                window.history.back();
            }

            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase();
                if (query.length >= 2) {
                    const filteredInvestments = allInvestments.filter(investment =>
                        investment.company_name.toLowerCase().includes(query) ||
                        investment.description.toLowerCase().includes(query)
                    );
                    displayInvestments(filteredInvestments);
                } else if (query.length === 0) {
                    displayInvestments(allInvestments);
                }
            });

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

