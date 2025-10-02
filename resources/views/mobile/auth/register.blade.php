<!DOCTYPE html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>إنشاء حساب جديد - InvestHub</title>
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
                direction: rtl;
                padding: 1rem 0;
            }

            .register-container {
                background: white;
                padding: 2rem;
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                width: 90%;
                max-width: 500px;
                margin: 0 auto;
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

            .form-section {
                margin-bottom: 2rem;
            }

            .section-title {
                color: #2c3e50;
                font-size: 1.2rem;
                font-weight: 600;
                margin-bottom: 1rem;
                text-align: right;
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

            .risk-questions {
                text-align: right;
            }

            .question {
                margin-bottom: 1.5rem;
                padding: 1rem;
                background: #f8f9fa;
                border-radius: 10px;
            }

            .question h4 {
                color: #2c3e50;
                margin-bottom: 1rem;
                font-size: 1rem;
            }

            .question-options {
                display: flex;
                gap: 1rem;
                justify-content: flex-end;
            }

            .option {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .option input[type="radio"] {
                width: auto;
                margin: 0;
            }

            .option label {
                margin: 0;
                font-weight: normal;
                cursor: pointer;
            }

            .register-btn {
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

            .register-btn:hover {
                transform: translateY(-2px);
            }

            .back-link {
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
                .register-container {
                    margin: 1rem;
                    padding: 1.5rem;
                }

                .form-row {
                    flex-direction: column;
                    gap: 0;
                }

                .question-options {
                    flex-direction: column;
                    gap: 0.5rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="register-container">
            <div class="logo">
                <h1>InvestHub</h1>
                <p class="subtitle">إنشاء حساب جديد</p>
            </div>

            <form id="registerForm">
                <!-- Personal Information Section -->
                <div class="form-section">
                    <h3 class="section-title">البيانات الشخصية</h3>

                    <div class="form-group">
                        <label for="name">الاسم الكامل</label>
                        <input type="text" id="name" name="name" placeholder="أدخل اسمك الكامل" required>
                    </div>

                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" placeholder="example@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">رقم الجوال</label>
                        <input type="tel" id="phone" name="phone" placeholder="05xxxxxxxxx" required>
                    </div>

                    <div class="form-group">
                        <label for="password">كلمة المرور</label>
                        <input type="password" id="password" name="password" placeholder="أدخل كلمة المرور" required>
                    </div>

                    <div class="form-group">
                        <label for="id_number">رقم الهوية</label>
                        <input type="text" id="id_number" name="id_number" placeholder="أدخل رقم الهوية" required>
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">تاريخ الميلاد</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required>
                    </div>
                </div>

                <!-- Financial Data Section -->
                <div class="form-section">
                    <h3 class="section-title">البيانات المالية</h3>

                    <div class="form-group">
                        <label for="marital_status">الحالة الاجتماعية</label>
                        <select id="marital_status" name="marital_status" required>
                            <option value="">اختر حالتك الاجتماعية</option>
                            <option value="single">أعزب</option>
                            <option value="married">متزوج</option>
                            <option value="divorced">مطلق</option>
                            <option value="widowed">أرمل</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="family_members_count">عدد أفراد الأسرة</label>
                        <div class="family-members">
                            <button type="button" onclick="decreaseFamilyMembers()">-</button>
                            <input type="number" id="family_members_count" name="family_members_count" value="1"
                                min="1" readonly>
                            <button type="button" onclick="increaseFamilyMembers()">+</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="education_level">مستوى التعليم</label>
                        <select id="education_level" name="education_level" required>
                            <option value="">اختر مستوى التعليم</option>
                            <option value="high_school">ثانوي</option>
                            <option value="diploma">دبلوم</option>
                            <option value="bachelor">بكالوريوس</option>
                            <option value="master">ماجستير</option>
                            <option value="phd">دكتوراه</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="annual_income">الدخل السنوي (بالريال السعودي)</label>
                        <input type="number" id="annual_income" name="annual_income" placeholder="أدخل دخلك السنوي"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="total_savings">إجمالي التوفير (بالريال السعودي)</label>
                        <input type="number" id="total_savings" name="total_savings" placeholder="أدخل إجمالي توفيرك"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="bank_name">البنك الذي تتعامل معه</label>
                        <select id="bank_name" name="bank_name" required>
                            <option value="">اختر البنك</option>
                            <option value="البنك الأهلي السعودي">البنك الأهلي السعودي</option>
                            <option value="بنك الراجحي">بنك الراجحي</option>
                            <option value="البنك السعودي الفرنسي">البنك السعودي الفرنسي</option>
                            <option value="البنك السعودي للاستثمار">البنك السعودي للاستثمار</option>
                            <option value="البنك السعودي الهولندي">البنك السعودي الهولندي</option>
                        </select>
                    </div>
                </div>

                <!-- Risk Assessment Section -->
                <div class="form-section">
                    <h3 class="section-title">تقييم المعرفة بالمخاطر</h3>

                    <div class="risk-questions">
                        <div class="question">
                            <h4>هل لديك خبرة سابقة في الاستثمار بالأسهم؟</h4>
                            <div class="question-options">
                                <div class="option">
                                    <input type="radio" id="exp_yes" name="has_investment_experience"
                                        value="1" required>
                                    <label for="exp_yes">نعم</label>
                                </div>
                                <div class="option">
                                    <input type="radio" id="exp_no" name="has_investment_experience"
                                        value="0" required>
                                    <label for="exp_no">لا</label>
                                </div>
                            </div>
                        </div>

                        <div class="question">
                            <h4>هل أنت مستعد للمخاطرة بخسارة جزء من رأس مالك؟</h4>
                            <div class="question-options">
                                <div class="option">
                                    <input type="radio" id="risk_yes" name="willing_to_risk_capital"
                                        value="1" required>
                                    <label for="risk_yes">نعم</label>
                                </div>
                                <div class="option">
                                    <input type="radio" id="risk_no" name="willing_to_risk_capital"
                                        value="0" required>
                                    <label for="risk_no">لا</label>
                                </div>
                            </div>
                        </div>

                        <div class="question">
                            <h4>هل لديك مصدر دخل ثابت لتغطية نفقاتك الأساسية؟</h4>
                            <div class="question-options">
                                <div class="option">
                                    <input type="radio" id="income_yes" name="has_stable_income" value="1"
                                        required>
                                    <label for="income_yes">نعم</label>
                                </div>
                                <div class="option">
                                    <input type="radio" id="income_no" name="has_stable_income" value="0"
                                        required>
                                    <label for="income_no">لا</label>
                                </div>
                            </div>
                        </div>

                        <div class="question">
                            <h4>هل تخطط لسحب أموالك المستثمرة في غضون 1-3 سنوات؟</h4>
                            <div class="question-options">
                                <div class="option">
                                    <input type="radio" id="withdraw_yes" name="plans_short_term_withdrawal"
                                        value="1" required>
                                    <label for="withdraw_yes">نعم</label>
                                </div>
                                <div class="option">
                                    <input type="radio" id="withdraw_no" name="plans_short_term_withdrawal"
                                        value="0" required>
                                    <label for="withdraw_no">لا</label>
                                </div>
                            </div>
                        </div>

                        <div class="question">
                            <h4>هل تفضل الاستثمارات ذات العوائد المرتفعة والمخاطر العالية؟</h4>
                            <div class="question-options">
                                <div class="option">
                                    <input type="radio" id="high_risk_yes" name="prefers_high_risk_high_return"
                                        value="1" required>
                                    <label for="high_risk_yes">نعم</label>
                                </div>
                                <div class="option">
                                    <input type="radio" id="high_risk_no" name="prefers_high_risk_high_return"
                                        value="0" required>
                                    <label for="high_risk_no">لا</label>
                                </div>
                            </div>
                        </div>

                        <div class="question">
                            <h4>هل تستشير مستشاراً مالياً قبل اتخاذ قرارات الاستثمار؟</h4>
                            <div class="question-options">
                                <div class="option">
                                    <input type="radio" id="advisor_yes" name="consults_financial_advisor"
                                        value="1" required>
                                    <label for="advisor_yes">نعم</label>
                                </div>
                                <div class="option">
                                    <input type="radio" id="advisor_no" name="consults_financial_advisor"
                                        value="0" required>
                                    <label for="advisor_no">لا</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="register-btn">إكمال التسجيل</button>
                <a href="#" class="back-link">العودة لتسجيل الدخول</a>
            </form>
        </div>

        <div class="footer">
            Made with ❤️
        </div>

        <script>
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

            document.getElementById('registerForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const data = Object.fromEntries(formData.entries());

                // Convert radio button values to boolean
                data.has_investment_experience = data.has_investment_experience === '1';
                data.willing_to_risk_capital = data.willing_to_risk_capital === '1';
                data.has_stable_income = data.has_stable_income === '1';
                data.plans_short_term_withdrawal = data.plans_short_term_withdrawal === '1';
                data.prefers_high_risk_high_return = data.prefers_high_risk_high_return === '1';
                data.consults_financial_advisor = data.consults_financial_advisor === '1';

                // API call to register
                fetch('/api/v1/user/register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Store token and redirect
                            localStorage.setItem('token', data.data.token);
                            alert('تم إنشاء الحساب بنجاح!');
                            window.location.href = '/dashboard';
                        } else {
                            alert(data.message || 'حدث خطأ في إنشاء الحساب');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ في الاتصال');
                    });
            });

            // Handle back link
            document.querySelector('.back-link').addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '/login';
            });
        </script>
    </body>

</html>

