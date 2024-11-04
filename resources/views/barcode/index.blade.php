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
                            <h6 class="text-white text-capitalize text-center">القائمة</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">اختيار</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">اسم باركود</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الصورة</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الحالة</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">تاريخ الإنشاء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barcodes as $barcode)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="image-checkbox" data-image="{{ $barcode->code }}" id="image-{{ $barcode->id }}">
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $barcode->name }}</h6>
                                        </td>
                                        <td>
                                            <img src="{{ $barcode->code }}" alt="Barcode for {{ $barcode->name }}" style="width: 100px; height: auto;">
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($barcode->is_active)
                                                <span class="badge badge-sm bg-gradient-success">نشط</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">غير نشط</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $barcode->created_at->diffForHumans() }}</span>
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
    document.getElementById('select-all').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.image-checkbox');
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked; // إذا كانت جميع الصناديق محددة، قم بإلغاء تحديدها، وإلا حددها
        });
    });

    document.getElementById('download-selected').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.image-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('يرجى اختيار صورة واحدة على الأقل لتحميلها.');
            return;
        }
        checkboxes.forEach(checkbox => {
            const imageSrc = checkbox.getAttribute('data-image');
            const link = document.createElement('a');
            link.href = imageSrc; // رابط الصورة
            link.download = ''; // يجعل الرابط قابل للتنزيل
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link); // إزالة الرابط بعد التحميل
        });
    });
</script>

@endsection
