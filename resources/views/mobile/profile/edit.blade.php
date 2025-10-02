<!DOCTYPE html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>تعديل الملف الشخصي - InvestHub</title>
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
                font-size: 1.3rem;
                margin-bottom: 0.5rem;
            }

            .container {
                padding: 1rem;
                max-width: 500px;
                margin: 0 auto;
                padding-bottom: 80px;
            }

            .form-section {
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
                margin-bottom: 1.5rem;
                border-bottom: 2px solid #e1e8ed;
                padding-bottom: 0.5rem;
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

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 12px 15px;
                border: 2px solid #e1e8ed;
                border-radius: 10px;
                font-size: 1rem;
                transition: border-color 0.3s;
            }

            .form-group input:focus,
            .form-group select:focus {
                outline: none;
                border-color: #667eea;
            }

            .form-row {
                display: flex;
                gap: 1rem;
            }

            .form-row .form-group {
                flex: 1;
            }

            .family-members {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .family-members input {
                text-align: center;
                width: 80px;
            }

            .family-members button {
                background: #667eea;
                color: white;
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
                cursor: pointer;
                transition: background 0.3s;
            }

            .family-members button:hover {
                background: #5a67d8;
            }

            .save-btn {
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
                margin-top: 1rem;
            }

            .save-btn:hover {
                transform: translateY(-2px);
            }

            .save-btn:disabled {
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

            .success {
                text-align: center;
                padding: 1rem;
                color: #27ae60;
                background: #e8f5e8;
                border-radius: 10px;
                margin-bottom: 1rem;
                display: none;
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

                .form-section {
                    padding: 1rem;
                }

                .form-row {
                    flex-direction: column;
                    gap: 0;
                }
            }
        </style>
    </head>

    <body>
        <div class="header">
            <h1>تعديل الملف الشخصي</h1>
        </div>

        <div class="container">
            <div class="success" id="successMessage">
                تم حفظ التغييرات بنجاح!
            </div>

            <div id="profileContainer">
                <div class="loading">جاري تحميل البيانات...</div>
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
            let userData = null;

            // Load user profile on page load
            document.addEventListener('DOMContentLoaded', function() {
                loadUserProfile();
            });

            function loadUserProfile() {
                const token = localStorage.getItem('token');
                if (!token) {
                    alert('يجب تسجيل الدخول أولاً');
                    window.location.href = '/login';
                    return;
                }

                fetch('/api/v1/user/profile', {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            userData = data.data.user;
                            displayProfileForm(userData);
                        } else {
                            showError('فشل في تحميل البيانات');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('حدث خطأ في الاتصال');
                    });
            }

            function displayProfileForm(user) {
                const container = document.getElementById('profileContainer');

                container.innerHTML = `
                <form id="profileForm">
                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">البيانات الشخصية</h3>
                        
                        <div class="form-group">
                            <label for="name">الاسم الكامل</label>
                            <input type="text" id="name" name="name" value="${user.name || ''}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" value="${user.email || ''}" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">رقم الجوال</label>
                            <input type="tel" id="phone" name="phone" value="${user.phone || ''}" required>
                        </div>

                        <div class="form-group">
                            <label for="id_number">رقم الهوية</label>
                            <input type="text" id="id_number" name="id_number" value="${user.id_number || ''}" required>
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth">تاريخ الميلاد</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="${user.date_of_birth || ''}" required>
                        </div>

                        <div class="form-group">
                            <label for="marital_status">الحالة الاجتماعية</label>
                            <select id="marital_status" name="marital_status" required>
                                <option value="">اختر حالتك الاجتماعية</option>
                                <option value="single" ${user.marital_status === 'single' ? 'selected' : ''}>أعزب</option>
                                <option value="married" ${user.marital_status === 'married' ? 'selected' : ''}>متزوج</option>
                                <option value="divorced" ${user.marital_status === 'divorced' ? 'selected' : ''}>مطلق</option>
                                <option value="widowed" ${user.marital_status === 'widowed' ? 'selected' : ''}>أرمل</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="family_members_count">عدد أفراد الأسرة</label>
                            <div class="family-members">
                                <button type="button" onclick="decreaseFamilyMembers()">-</button>
                                <input type="number" id="family_members_count" name="family_members_count" value="${user.family_members_count || 1}" min="1" readonly>
                                <button type="button" onclick="increaseFamilyMembers()">+</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="education_level">مستوى التعليم</label>
                            <select id="education_level" name="education_level" required>
                                <option value="">اختر مستوى التعليم</option>
                                <option value="high_school" ${user.education_level === 'high_school' ? 'selected' : ''}>ثانوي</option>
                                <option value="diploma" ${user.education_level === 'diploma' ? 'selected' : ''}>دبلوم</option>
                                <option value="bachelor" ${user.education_level === 'bachelor' ? 'selected' : ''}>بكالوريوس</option>
                                <option value="master" ${user.education_level === 'master' ? 'selected' : ''}>ماجستير</option>
                                <option value="phd" ${user.education_level === 'phd' ? 'selected' : ''}>دكتوراه</option>
                            </select>
                        </div>
                    </div>

                    <!-- Financial Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">البيانات المالية</h3>
                        
                        <div class="form-group">
                            <label for="annual_income">الدخل السنوي (بالريال السعودي)</label>
                            <input type="number" id="annual_income" name="annual_income" value="${user.annual_income || ''}" required>
                        </div>

                        <div class="form-group">
                            <label for="total_savings">إجمالي التوفير (بالريال السعودي)</label>
                            <input type="number" id="total_savings" name="total_savings" value="${user.total_savings || ''}" required>
                        </div>

                        <div class="form-group">
                            <label for="bank_name">البنك الذي تتعامل معه</label>
                            <select id="bank_name" name="bank_name" required>
                                <option value="">اختر البنك</option>
                                <option value="البنك الأهلي السعودي" ${user.bank_name === 'البنك الأهلي السعودي' ? 'selected' : ''}>البنك الأهلي السعودي</option>
                                <option value="بنك الراجحي" ${user.bank_name === 'بنك الراجحي' ? 'selected' : ''}>بنك الراجحي</option>
                                <option value="البنك السعودي الفرنسي" ${user.bank_name === 'البنك السعودي الفرنسي' ? 'selected' : ''}>البنك السعودي الفرنسي</option>
                                <option value="البنك السعودي للاستثمار" ${user.bank_name === 'البنك السعودي للاستثمار' ? 'selected' : ''}>البنك السعودي للاستثمار</option>
                                <option value="البنك السعودي الهولندي" ${user.bank_name === 'البنك السعودي الهولندي' ? 'selected' : ''}>البنك السعودي الهولندي</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="save-btn">حفظ التغييرات</button>
                </form>
            `;

                // Add form submission handler
                document.getElementById('profileForm').addEventListener('submit', handleFormSubmit);
            }

            function handleFormSubmit(e) {
                e.preventDefault();

                const formData = new FormData(e.target);
                const data = Object.fromEntries(formData.entries());

                const token = localStorage.getItem('token');

                fetch('/api/v1/user/profile', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + token
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showSuccess();
                        } else {
                            alert(data.message || 'فشل في حفظ البيانات');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ في الاتصال');
                    });
            }

            function increaseFamilyMembers() {
                const input = document.getElementById('family_members_count');
                input.value = parseInt(input.value) + 1;
            }

            function decreaseFamilyMembers() {
                const input = document.getElementById('family_members_count');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            }

            function showSuccess() {
                const successMessage = document.getElementById('successMessage');
                successMessage.style.display = 'block';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000);
            }

            function showError(message) {
                document.getElementById('profileContainer').innerHTML =
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

