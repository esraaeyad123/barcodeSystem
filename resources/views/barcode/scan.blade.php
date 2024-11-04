@extends('app')


@section('content')


<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <title>اختبار QR Code</title>
</head>
<body>
    <h6>اختبار QR Code</h6>
    <div id="reader" style="width: 600px; height: 400px;"></div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const html5QrCode = new Html5Qrcode("reader");

        function onScanSuccess(qrCodeMessage) {
            console.log(`باركود تم اكتشافه: ${qrCodeMessage}`);

            // إرسال الطلب إلى الخادم لتغيير الحالة
            fetch(`/barcodes/toggle/${qrCodeMessage}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                alert(data.message || 'تم تغيير الحالة بنجاح.');
                html5QrCode.stop(); // إيقاف الكاميرا بعد النجاح
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء الاتصال بالخادم.');
            });
        }

        function onScanError(errorMessage) {
            console.warn(`خطأ أثناء القراءة: ${errorMessage}`);
        }

        // بدء عملية المسح
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 30, qrbox: 250 }, // ضبط FPS وحجم qrbox
            onScanSuccess,
            onScanError
        ).catch(err => {
            console.error(`Unable to start scanning: ${err}`);
        });
    </script>
</body>
</html>
@endsection
