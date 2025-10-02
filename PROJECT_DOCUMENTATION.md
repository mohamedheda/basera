# InvestHub - تطبيق الاستثمار الذكي

## نظرة عامة
InvestHub هو تطبيق استثمار ذكي يوفر للمستخدمين فرص استثمارية متنوعة مع نظام تقييم المخاطر والاشتراكات المدفوعة.

## الميزات الرئيسية

### 1. نظام المصادقة الكامل
- تسجيل الدخول بالهاتف وكلمة المرور
- تسجيل الدخول بـ Google
- استعادة كلمة المرور
- التحقق من رقم الهاتف (OTP)
- إنشاء حساب جديد مع البيانات الكاملة

### 2. إدارة الملف الشخصي
- البيانات الشخصية (الاسم، البريد، الهاتف، رقم الهوية، تاريخ الميلاد)
- الحالة الاجتماعية وعدد أفراد الأسرة
- مستوى التعليم
- البيانات المالية (الدخل السنوي، التوفير، البنك)

### 3. نظام تقييم المخاطر
- 6 أسئلة لتقييم مستوى المخاطرة
- حساب نقاط المخاطر تلقائياً
- تصنيف المستثمر (محافظ، متوسط، مخاطر عالية)
- توصيات استثمارية مخصصة

### 4. الفرص الاستثمارية
- عرض الفرص الاستثمارية المتاحة
- تفاصيل كل فرصة (الشركة، السعر، العائد المتوقع)
- تصفية حسب السوق والقطاع ومستوى المخاطر
- البحث في الفرص
- توصيات مخصصة حسب ملف المخاطر

### 5. نظام الباقات والاشتراكات
- 3 أنواع باقات (شهرية، نصف سنوية، سنوية)
- ميزات مختلفة لكل باقة
- إدارة الاشتراكات النشطة
- إلغاء الاشتراكات

## التقنيات المستخدمة

### Backend
- **Laravel 12** - إطار العمل الرئيسي
- **JWT Authentication** - للمصادقة
- **Laravel Sanctum** - لإدارة الجلسات
- **MySQL** - قاعدة البيانات
- **Laratrust** - لإدارة الصلاحيات

### Frontend
- **HTML5/CSS3** - واجهات المستخدم
- **JavaScript** - التفاعل والـ API calls
- **Responsive Design** - تصميم متجاوب للجوال
- **Arabic RTL Support** - دعم اللغة العربية

## هيكل قاعدة البيانات

### جداول المستخدمين
- `users` - بيانات المستخدمين الأساسية
- `otps` - أكواد التحقق
- `risk_assessments` - تقييمات المخاطر

### جداول الاستثمار
- `investment_opportunities` - الفرص الاستثمارية
- `subscription_packages` - باقات الاشتراك
- `user_subscriptions` - اشتراكات المستخدمين

## API Endpoints

### المصادقة
```
POST /api/v1/auth/sign/in          - تسجيل الدخول
POST /api/v1/auth/sign/up          - تسجيل حساب جديد
POST /api/v1/auth/sign/out         - تسجيل الخروج
POST /api/v1/otp/send              - إرسال OTP
POST /api/v1/otp/verify            - التحقق من OTP
POST /api/v1/password/forgot       - استعادة كلمة المرور
POST /api/v1/password/reset        - إعادة تعيين كلمة المرور
```

### إدارة المستخدم
```
GET  /api/v1/user/profile          - عرض الملف الشخصي
PUT  /api/v1/user/profile          - تحديث الملف الشخصي
POST /api/v1/user/register         - تسجيل كامل مع البيانات
GET  /api/v1/user/dashboard        - لوحة التحكم
```

### الفرص الاستثمارية
```
GET  /api/v1/investments           - قائمة الفرص
GET  /api/v1/investments/{id}      - تفاصيل الفرصة
GET  /api/v1/investments/search    - البحث في الفرص
GET  /api/v1/investments/recommendations - توصيات مخصصة
GET  /api/v1/investments/statistics - إحصائيات الفرص
```

### الباقات والاشتراكات
```
GET  /api/v1/subscriptions/packages - قائمة الباقات
GET  /api/v1/subscriptions/packages/{id} - تفاصيل الباقة
POST /api/v1/subscriptions/subscribe - الاشتراك في باقة
GET  /api/v1/subscriptions/my-subscriptions - اشتراكات المستخدم
GET  /api/v1/subscriptions/active - الاشتراك النشط
POST /api/v1/subscriptions/cancel - إلغاء الاشتراك
```

### تقييم المخاطر
```
GET  /api/v1/risk                  - عرض تقييم المخاطر
POST /api/v1/risk                  - إنشاء/تحديث التقييم
GET  /api/v1/risk/questions        - أسئلة التقييم
GET  /api/v1/risk/profile-explanation - شرح ملف المخاطر
```

## صفحات الواجهة

### صفحات المصادقة
- `login.blade.php` - صفحة تسجيل الدخول
- `register.blade.php` - صفحة إنشاء حساب جديد
- `forgot-password.blade.php` - صفحة استعادة كلمة المرور
- `verification.blade.php` - صفحة التحقق من OTP

### صفحات التطبيق
- `investments/index.blade.php` - قائمة الفرص الاستثمارية
- `investments/show.blade.php` - تفاصيل الفرصة الاستثمارية
- `subscriptions/index.blade.php` - صفحة الباقات
- `profile/edit.blade.php` - تعديل الملف الشخصي

## كيفية التشغيل

### متطلبات النظام
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js (اختياري للـ assets)

### خطوات التثبيت

1. **استنساخ المشروع**
```bash
git clone <repository-url>
cd investHub
```

2. **تثبيت المتطلبات**
```bash
composer install
```

3. **إعداد البيئة**
```bash
cp .env.example .env
php artisan key:generate
```

4. **إعداد قاعدة البيانات**
```bash
# تحديث ملف .env بقاعدة البيانات
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=investhub
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **تشغيل الـ Migrations**
```bash
php artisan migrate
```

6. **تشغيل الـ Seeders**
```bash
php artisan db:seed
```

7. **تشغيل الخادم**
```bash
php artisan serve
```

## البيانات التجريبية

تم إنشاء البيانات التجريبية التالية:

### الفرص الاستثمارية
- شركة أرامكو السعودية (السوق السعودي - الطاقة)
- آبل إنك (السوق الأمريكي - التكنولوجيا)
- بنك الراجحي (السوق السعودي - المصرفية)
- شركة سابك (السوق السعودي - الطاقة)
- تسلا (السوق الأمريكي - التكنولوجيا)

### الباقات
- الباقة الشهرية (500 ريال)
- الباقة النصف سنوية (2500 ريال) - الأكثر شعبية
- الباقة السنوية (4800 ريال)

## الأمان

- تشفير كلمات المرور باستخدام bcrypt
- JWT tokens للمصادقة
- التحقق من صحة البيانات (Validation)
- حماية من SQL Injection
- CSRF Protection

## الدعم

للحصول على الدعم أو الإبلاغ عن مشاكل، يرجى التواصل عبر:
- البريد الإلكتروني: support@investhub.com
- الهاتف: +966 XX XXX XXXX

## الترخيص

هذا المشروع مرخص تحت رخصة MIT - راجع ملف LICENSE للتفاصيل.

