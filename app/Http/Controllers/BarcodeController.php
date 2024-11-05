<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Http\Requests\StoreBarcodeRequest;
use App\Http\Requests\UpdateBarcodeRequest;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;


class BarcodeController extends Controller
{



    public function all (){

       $barcodes = Barcode::all();
       return view('barcode.index', compact('barcodes'));
   }


    public function index (){
        $barcodes = Barcode::all();

        $totalBarcodes = Barcode::count();

        // إحصاء عدد الباركودات الفعالة
        $activeBarcodes = Barcode::where('is_active', true)->count();

        // إحصاء عدد الباركودات غير الفعالة
        $inactiveBarcodes = Barcode::where('is_active', false)->count();

        // جلب الصور لعرضها
        $barcodeImages = scandir(public_path('img/barcodes'));

        return view('app', compact('totalBarcodes', 'activeBarcodes', 'inactiveBarcodes', 'barcodeImages'));

    }
    public function show($id)
{
    // البحث عن الباركود بواسطة ID
    $barcode = Barcode::findOrFail($id);

    // توليد صورة الباركود إذا لزم الأمر
    $barcodeImage = $barcode->code; // أو يمكنك استخدام دالة generateBarcodeImage إذا كنت تحتاجها

    return view('barcode.show', compact('barcode', 'barcodeImage'));
}

public function create()
{
    return view('barcode.create');
}


public function toggle($code)
{
    $barcode = Barcode::where('name', trim($code))->first();

    if (!$barcode) {
     return response()->json(['message' => "باركود '$code' غير موجود!"], 404);
    }

    if ($barcode->is_active == 1) {
        $barcode->is_active = 0; // تغيير الحالة
        $barcode->save(); // حفظ التغييرات

        return response()->json(['message' => 'تم تغيير حالة الباركود بنجاح!']);
    } else {
        return response()->json(['message' => 'حالة الباركود بالفعل صفر!']);
    }


    return response()->json(['message' => 'تم تغيير حالة الباركود بنجاح!']);
}



    public function scan()
    {
        return view('barcode.scan'); // تأكد من أن اسم العرض صحيح
    }


    public function store(StoreBarcodeRequest $request)
{
    $fontPath = public_path('fonts/alfont_com_AlFont_com_arial.ttf');

    $request->validate([
        'count' => 'required|integer|min:1',
    ]);

    $count = $request->input('count');

    for ($i = 0; $i < $count; $i++) {
        // توليد رقم عشوائي
        $randomNumber = rand(1000, 9999);
        $barcodeName = 'QrA&M' . $randomNumber;

        // إنشاء كود QR
        $qrCode = new QrCode($barcodeName);
        $qrCode->setSize(180); // تقليص حجم QR Code
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // دمج الباركود مع التصميم
        $designImage = imagecreatefromjpeg(public_path('img/invitation.jpg'));
        $barcodeImage = imagecreatefromstring($result->getString());

        // أبعاد التصميم
        $designWidth = imagesx($designImage);
        $designHeight = imagesy($designImage);

        // ضبط موقع الباركود ليكون في المنتصف السفلي
        $barcodeX = ($designWidth - imagesx($barcodeImage)) / 2;
        $barcodeY = $designHeight - imagesy($barcodeImage) - 55;

        // دمج الصور
        imagecopy($designImage, $barcodeImage, $barcodeX, $barcodeY, 0, 0, imagesx($barcodeImage), imagesy($barcodeImage));

        // إعداد النص (اسم الباركود)
        $textColor = imagecolorallocate($designImage, 0, 0, 0);
        $fontSize = 14; // حجم الخط الجديد
        $textYOffset = 30; // مسافة إضافية لتحريك النص أسفل الباركود

        // تحديد موقع النص ليكون أسفل الباركود في المنتصف
        $textX = $barcodeX + (imagesx($barcodeImage) / 2) - (strlen($barcodeName) * $fontSize / 4);
        $textY = $barcodeY + imagesy($barcodeImage) + $textYOffset ; // وضع النص أسفل الباركود

        // إضافة اسم الباركود على الصورة
        imagettftext($designImage, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $barcodeName);

        // حفظ الصورة النهائية
        $barcodesDirectory = public_path('img/barcodes');
        if (!is_dir($barcodesDirectory)) {
            mkdir($barcodesDirectory, 0755, true);
        }

        // مسار الصورة النهائية
        $finalImagePath = $barcodesDirectory . '/' . $barcodeName . '.jpg';

        // حفظ الصورة بصيغة JPG
        imagejpeg($designImage, $finalImagePath, 100);

        // تنظيف الذاكرة
        imagedestroy($designImage);
        imagedestroy($barcodeImage);

        // حفظ معلومات الباركود في قاعدة البيانات
        Barcode::create([
            'name' => $barcodeName,
            'code' => 'data:image/jpeg;base64,' . base64_encode($result->getString()),
            'is_active' => true,
        ]);
    }

    // العودة إلى نفس الصفحة مع رسالة النجاح
    return back()->with('success', 'تم إنشاء الباركودات وحفظها في صور منفصلة بنجاح!');
}



    public function showBarcodes()
    {
        // مسار مجلد الباركودات
        $barcodesDirectory = public_path('img/barcodes');

        // الحصول على جميع الملفات في المجلد
        $barcodeImages = array_diff(scandir($barcodesDirectory), ['..', '.']);

        // ترتيب الملفات حسب تاريخ آخر تعديل (الأحدث أولاً)
        usort($barcodeImages, function($a, $b) use ($barcodesDirectory) {
            return filemtime($barcodesDirectory . '/' . $b) <=> filemtime($barcodesDirectory . '/' . $a);
        });

        return view('barcode.showBarcodes', compact('barcodeImages'));
    }



}
