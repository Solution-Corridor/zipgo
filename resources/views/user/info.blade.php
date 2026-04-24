<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    @include('user.includes.general_style')
    <title>Information</title>

    <!-- Optional: If 'Noto Nastaliq Urdu' is not already loaded -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;700&display=swap" rel="stylesheet"> -->
</head>
<body class="min-h-screen text-gray-200 flex items-start justify-center">

<div class="w-full max-w-[420px] min-h-screen relative" style="background: #0B0B12;">

    @include('user.includes.top_greetings')

    <!-- ================== Your content starts here ================== -->
    <div class="px-5 py-4" style="padding-bottom: 90px;">
        <h2 class="text-xl font-bold text-white mb-5 text-center">
            پلیٹ فارم کی معلومات
        </h2>

        <style>
            .urdu-content {
                direction: rtl;
                text-align: right;
                /* font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', Georgia, serif; */
                line-height: 2.2;
                letter-spacing: 0.4px;
                font-size: 15px;
                word-wrap: break-word;
            }
        </style>

        <div class="urdu-content text-gray-300 text-sm space-y-5 leading-relaxed">
            <p>
                <strong>فیوچر انویسٹ</strong> ایک محفوظ، شفاف اور شرعی اصولوں کے مطابق سرمایہ کاری کا جدید ڈیجیٹل پلیٹ فارم ہے۔
            </p>

            <p>
                ہمارا مقصد صارفین کو باوقار اور پائیدار مواقع فراہم کرنا ہے تاکہ وہ اپنی جمع پونجی کو حلال اور منافع بخش طریقے سے بڑھا سکیں۔ یہاں آپ شراکت کے ماڈل کے تحت سرمایہ لگاتے ہیں۔ کمپنی آپ کے سرمائے کو مختلف کاروباری شعبوں میں پیشہ ورانہ طریقے سے استعمال کرتی ہے اور متفقہ شرائط کے تحت حلال منافع تقسیم کرتی ہے۔
            </p>

            <p>
                پلیٹ فارم پر منافع حاصل کرنے کے چار اہم ذرائع درج ذیل ہیں:
            </p>

            <p class="pr-2 space-y-2">
                1️⃣ <strong>سرمایہ کاری منصوبہ</strong> — منتخب پلان کے تحت روزانہ منافع حاصل کریں۔<br>
                2️⃣ <strong>ریفرل پروگرام</strong> — دوستوں اور جاننے والوں کو مدعو کریں اور لیول 1 سے 2 تک ریفرل بونس حاصل کریں۔<br>
                3️⃣ <strong>روزانہ ٹاسکس</strong> — سادہ ٹاسکس مکمل کرکے فوری انعامات کمائیں۔<br>
                4️⃣ <strong>ہولڈ ریوارڈ</strong> — اگر 5 دن تک واپسی نہ کی جائے تو دستیاب بیلنس پر روزانہ 2% اضافی انعام حاصل کریں۔
            </p>

            <div class="bg-gray-800/50 p-4 rounded-lg mt-6 border border-gray-700">
                <p class="font-medium text-white mb-2">اہم تفصیلات:</p>
                <ul class="list-disc list-inside space-y-1 text-gray-300">
                    <li>کم از کم سرمایہ کاری: 1,000 روپے</li>
                    <li>روزانہ منافع: منتخب پلان کے مطابق</li>
                    <li>واپسی کی درخواست: 24 گھنٹوں کے اندر عمل درآمد</li>
                </ul>
            </div>

            <p class="text-purple-300 font-medium mt-8 text-center italic">
                ذمہ داری کے ساتھ سرمایہ لگائیں۔ مستقل آمدن حاصل کریں۔ مل کر خوشحالی کی طرف بڑھیں۔
            </p>
        </div>
    </div>
    <!-- ================== Your content ends here ================== -->

    @include('user.includes.bottom_navigation')

</div> <!-- end container -->

</body>
</html>