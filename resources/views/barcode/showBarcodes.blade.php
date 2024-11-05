@extends('app')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-2">
        <button id="download-selected" class="btn bg-gradient-dark" >تحميل </button>

        <button id="select-all" class="btn btn-secondary ">اختيار الكل</button>
        <a href="{{ route('barcodes.create') }}" class="btn alert-secondary  text-white" >انشاء الأكواد  </a>


        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize text-center">الدعوات</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الصورة</th>

                                </thead>
                                <tbody>
                                    @foreach ($barcodeImages as $image)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="image-checkbox" data-image="{{ asset('img/barcodes/' . $image) }}" id="image-{{ $loop->index }}">
                                            </td>
                                            <td>{{ $image }}</td>
                                            <td class="card mb-4">
                                                <img src="{{ asset('img/barcodes/' . $image) }}" class="card-img-top" style="width: 25%; height: auto;" alt="Barcode Image">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
 document.getElementById('download-selected').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('.image-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('يرجى اختيار صورة واحدة على الأقل لتحميلها.');
        return;
    }
    checkboxes.forEach(checkbox => {
        const imageSrc = checkbox.getAttribute('data-image');
        const link = document.createElement('a');
        link.href = imageSrc; // المسار الكامل للصورة
        link.download = imageSrc.split('/').pop(); // اسم الملف للتنزيل
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link); // إزالة الرابط بعد التحميل
    });
});

</script>

@endsection
