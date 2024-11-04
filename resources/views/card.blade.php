<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دعوة</title>
    <style>
        .invitation-card {
            width: 400px;
            height: 200px;
            border: 1px solid #ccc;
            padding: 20px;
            text-align: center;
            position: relative;
            margin: 20px;
        }
        .barcode {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>
    <div class="invitation-card">
        <h1>دعوة لحضور حدث خاص</h1>
        <p>ندعوكم لحضور...</p>
        <div class="barcode" id="barcode"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jbarcode/src/jbarcode.min.js"></script>
    <script>
        const barcodeData = "QrA&M1234"; // هنا يمكنك إدخال بيانات الباركود التي تم إنشاؤها
        JsBarcode("#barcode", barcodeData, { format: "CODE128" });
    </script>
</body>
</html>
