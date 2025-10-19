# خطة تنفيذ In-App Purchases & Google Play Billing

## 📋 نظرة عامة Overview

سنقوم بإضافة نظام شراء داخل التطبيق (IAP) مع التكامل الكامل مع Google Play Store للسماح للمستخدمين بشراء باقات الاشتراك عبر Google Play.

---

## 🎯 المتطلبات Requirements

### Backend (Laravel):
1. ✅ جدول Subscriptions موجود بالفعل
2. 🔄 نحتاج إضافة حقول جديدة للتعامل مع Google Play
3. 🔄 إنشاء API endpoints للتحقق من المشتريات
4. 🔄 إعداد Webhooks لاستقبال إشعارات Google Play

### Mobile App:
1. تكامل Google Play Billing Library v5+
2. إعداد المنتجات (Products) في التطبيق
3. معالجة عملية الشراء
4. إرسال Receipt إلى Backend للتحقق

### Google Play Console:
1. إعداد حساب Google Play Developer
2. إنشاء المنتجات (Products/Subscriptions)
3. إعداد Service Account للـ API Access
4. تفعيل Real-time Developer Notifications

---

## 📊 الخطة التفصيلية - 5 مراحل

---

## 🔵 المرحلة 1: إعداد قاعدة البيانات (Backend)

### الخطوات:
1. ✅ جدول `subscription_packages` موجود
2. ✅ جدول `user_subscriptions` موجود
3. 🔄 إضافة حقول جديدة لـ Google Play

### الحقول المطلوبة في `user_subscriptions`:
```php
- payment_platform (enum: 'card', 'apple_pay', 'google_play')
- google_product_id (string, nullable)
- google_purchase_token (text, nullable)
- google_order_id (string, nullable)
- google_purchase_state (enum: 'pending', 'purchased', 'cancelled', 'refunded')
- google_acknowledged (boolean, default: false)
- receipt_data (json, nullable) // لحفظ بيانات الإيصال كاملة
```

### الحقول المطلوبة في `subscription_packages`:
```php
- google_product_id (string, nullable, unique) // مثل: com.investhub.monthly
- apple_product_id (string, nullable, unique) // للمستقبل
```

**المدة المتوقعة:** 30 دقيقة

---

## 🔵 المرحلة 2: إعداد Google Play Console

### الخطوات:

#### 2.1 إنشاء المنتجات في Google Play Console:
1. فتح Google Play Console
2. اختيار التطبيق
3. الذهاب إلى: **Monetize → Products → Subscriptions**
4. إنشاء subscription لكل باقة:
   - Product ID: `com.investhub.monthly`
   - الاسم والوصف
   - السعر والمدة
   - حالة: Active

#### 2.2 إعداد Service Account (للـ API Access):
1. Google Cloud Console → IAM & Admin → Service Accounts
2. Create Service Account
3. تنزيل JSON key file
4. في Google Play Console:
   - Setup → API access
   - ربط الـ Service Account
   - منح صلاحيات: **View financial data, Manage orders**

#### 2.3 تفعيل Real-time Developer Notifications:
1. في Google Play Console:
   - Monetization setup → Real-time developer notifications
2. تحديد topic name: `projects/YOUR_PROJECT/topics/play-subscriptions`
3. حفظ الـ topic name

**المدة المتوقعة:** 1-2 ساعة

---

## 🔵 المرحلة 3: Backend API Implementation

### 3.1 Migration لإضافة الحقول الجديدة

```bash
php artisan make:migration add_google_play_fields_to_subscriptions
```

### 3.2 API Endpoints المطلوبة:

#### A. Get Available Products
```
GET /api/v1/subscriptions/google-products
```
**Response:**
```json
{
  "status": 200,
  "data": [
    {
      "id": 1,
      "name": "Monthly Subscription",
      "google_product_id": "com.investhub.monthly",
      "price": 99.99,
      "duration_months": 1
    }
  ]
}
```

#### B. Verify Google Play Purchase
```
POST /api/v1/subscriptions/google-verify
```
**Request:**
```json
{
  "package_id": 1,
  "product_id": "com.investhub.monthly",
  "purchase_token": "gkilnn...",
  "order_id": "GPA.1234-5678-9012-34567"
}
```

**Process:**
1. استلام بيانات الشراء من التطبيق
2. التحقق من الـ purchase token عبر Google Play API
3. التأكد من أن الشراء صحيح وغير مستخدم
4. إنشاء/تحديث اشتراك المستخدم
5. إرجاع بيانات الاشتراك

#### C. Google Play Webhook (Real-time notifications)
```
POST /api/v1/webhooks/google-play
```
**Process:**
1. استقبال إشعارات من Google Play عن:
   - اشتراك جديد
   - تجديد اشتراك
   - إلغاء اشتراك
   - استرداد مبلغ
2. تحديث حالة الاشتراك في قاعدة البيانات

#### D. Check Subscription Status
```
GET /api/v1/subscriptions/status
```
**Response:**
```json
{
  "status": 200,
  "data": {
    "has_active_subscription": true,
    "subscription": {
      "package_name": "Monthly Premium",
      "start_date": "2025-01-01",
      "end_date": "2025-02-01",
      "payment_platform": "google_play",
      "auto_renew": true
    }
  }
}
```

**المدة المتوقعة:** 3-4 ساعات

---

## 🔵 المرحلة 4: Google Play API Integration (Server-Side Validation)

### 4.1 تثبيت Google API Client:
```bash
composer require google/apiclient
```

### 4.2 إنشاء Service للتحقق من المشتريات:

```php
// app/Http/Services/GooglePlayBillingService.php

class GooglePlayBillingService
{
    public function verifySubscription($packageName, $productId, $purchaseToken)
    {
        // استخدام Google Play Developer API
        // للتحقق من صحة الشراء
    }
    
    public function acknowledgeSubscription($packageName, $productId, $purchaseToken)
    {
        // تأكيد استلام الشراء
    }
    
    public function cancelSubscription($packageName, $subscriptionId, $token)
    {
        // إلغاء الاشتراك
    }
}
```

### 4.3 إعداد Google Service Account:
1. وضع ملف JSON key في: `storage/app/google/service-account.json`
2. إضافة في `.env`:
```env
GOOGLE_APPLICATION_CREDENTIALS=storage/app/google/service-account.json
GOOGLE_PLAY_PACKAGE_NAME=com.yourcompany.investhub
```

**المدة المتوقعة:** 2-3 ساعات

---

## 🔵 المرحلة 5: Testing & Security

### 5.1 Google Play Testing:
1. إضافة License Testers في Google Play Console
2. استخدام Test tracks (Internal/Closed/Open testing)
3. Test cards من Google Play

### 5.2 Security Best Practices:
- ✅ التحقق من جميع المشتريات server-side
- ✅ تخزين الـ purchase tokens بشكل آمن
- ✅ استخدام HTTPS فقط
- ✅ التحقق من توقيع الـ webhook requests
- ✅ منع استخدام نفس الـ purchase token مرتين
- ✅ Rate limiting على الـ API endpoints

### 5.3 Handling Edge Cases:
- تجديد تلقائي فاشل
- استرداد المبلغ (Refund)
- إلغاء الاشتراك
- تغيير الباقة (Upgrade/Downgrade)
- انتهاء صلاحية البطاقة

**المدة المتوقعة:** 2-3 ساعات

---

## 📱 جانب التطبيق (Mobile App) - معلومات للمطور

### المتطلبات من فريق Mobile:

#### 1. تثبيت Google Play Billing Library:
```gradle
dependencies {
    implementation 'com.android.billingclient:billing:5.2.1'
}
```

#### 2. Product IDs يجب أن تتطابق مع Backend:
- `com.investhub.monthly`
- `com.investhub.semi_annual`
- `com.investhub.annual`

#### 3. Purchase Flow:
1. استرجاع قائمة المنتجات من Backend
2. عرض الأسعار للمستخدم
3. بدء عملية الشراء عبر Google Play
4. بعد نجاح الشراء، إرسال purchase token إلى Backend
5. انتظار تأكيد من Backend
6. تحديث UI

#### 4. API Calls المطلوبة من التطبيق:
```kotlin
// 1. Get products
GET /api/v1/subscriptions/google-products

// 2. After successful purchase
POST /api/v1/subscriptions/google-verify
{
  "package_id": 1,
  "product_id": "com.investhub.monthly",
  "purchase_token": "...",
  "order_id": "..."
}

// 3. Check current subscription
GET /api/v1/subscriptions/status
```

---

## 🔄 Flow الكامل للعملية

### User Journey:
```
1. المستخدم يفتح صفحة الباقات في التطبيق
   ↓
2. التطبيق يطلب قائمة الباقات من Backend
   ↓
3. عرض الباقات مع أسعار Google Play
   ↓
4. المستخدم يضغط "اشترك الآن"
   ↓
5. فتح Google Play Billing Dialog
   ↓
6. المستخدم يكمل عملية الدفع
   ↓
7. Google Play يرجع purchase token
   ↓
8. التطبيق يرسل الـ token إلى Backend API
   ↓
9. Backend يتحقق من الشراء عبر Google Play API
   ↓
10. Backend يُنشئ/يحدث الاشتراك
   ↓
11. Backend يرسل تأكيد للتطبيق
   ↓
12. التطبيق يعرض رسالة نجاح ويحدث الواجهة
```

### Auto-Renewal Flow:
```
1. قبل انتهاء الاشتراك، Google Play يحاول التجديد
   ↓
2. إذا نجح: Google يرسل webhook notification
   ↓
3. Backend يستقبل الإشعار ويحدث الاشتراك
   ↓
4. إذا فشل: Google يرسل إشعار فشل
   ↓
5. Backend يعطل الاشتراك ويرسل إشعار للمستخدم
```

---

## 💰 Payment Platforms Comparison

| Feature | Card Payment | Google Play |
|---------|-------------|-------------|
| رسوم | 2-3% | 15-30% |
| تحصيل تلقائي | نعم | نعم |
| استرداد | يدوي | تلقائي |
| مدة المعالجة | فوري | فوري |
| أمان | عالي | عالي جداً |
| سهولة للمستخدم | متوسط | سهل جداً |

---

## 📝 Checklist قبل الإطلاق

### Backend:
- [ ] Migration منفذة
- [ ] API Endpoints جاهزة ومختبرة
- [ ] Google Service Account متصل
- [ ] Webhook endpoint يعمل
- [ ] Error handling كامل
- [ ] Logging للمشتريات

### Google Play Console:
- [ ] المنتجات منشورة
- [ ] Service Account مُعد
- [ ] Real-time notifications مفعلة
- [ ] Pricing صحيح
- [ ] Testing tracks جاهزة

### Security:
- [ ] Purchase tokens محفوظة بشكل آمن
- [ ] Server-side validation فعال
- [ ] HTTPS مفعل
- [ ] Rate limiting مضاف
- [ ] Duplicate purchase prevention

### Testing:
- [ ] شراء باقة (Test)
- [ ] تجديد تلقائي (Test)
- [ ] إلغاء اشتراك (Test)
- [ ] Refund handling (Test)
- [ ] Webhook notifications (Test)

---

## ⚠️ نقاط مهمة

1. **Google Play Commission**: 
   - أول سنة: 15%
   - بعد السنة الأولى: 30%

2. **Grace Period**: 
   - Google تعطي 3 أيام grace period عند فشل التجديد

3. **Acknowledgment**:
   - يجب acknowledge الشراء خلال 3 أيام وإلا سيتم refund تلقائياً

4. **Testing**:
   - استخدم test accounts دائماً قبل Production
   - لا تستخدم أموال حقيقية في الاختبار

5. **Compliance**:
   - يجب متابعة Google Play Policies
   - يجب وجود Privacy Policy و Terms واضحة

---

## 🎯 الخطوات التالية

### لنبدأ التنفيذ:

**اختر الخطوة الأولى التي تريد البدء بها:**

1. 🔵 **المرحلة 1**: إضافة حقول Google Play للـ database (30 دقيقة)
2. 🟢 **مساعدة في Google Play Console setup** (توجيهات فقط)
3. 🔴 **المرحلة 3**: تنفيذ الـ API endpoints مباشرة

**أو أخبرني إذا تريد:**
- توضيح أي جزء معين
- تعديل في الخطة
- البدء بترتيب مختلف

---

**⏱️ إجمالي الوقت المتوقع: 8-12 ساعة عمل**

