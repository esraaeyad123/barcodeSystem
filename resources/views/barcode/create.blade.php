@extends('app')


@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="col-md-12 mb-lg-0 mb-4">
    <div class="card mt-4">
        <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0 fs-4">إنشاء الباركود</h6> <!-- استخدام fs-4 لتكبير الخط -->
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('barcodes.store') }}" method="POST">
                        @csrf
                        <h6 class="mb-0 fs-4">عدد الباركود</h6> <!-- استخدام fs-4 لتكبير الخط -->

                        <div class="input-group input-group-outline mb-3"> <!-- إضافة mb-3 لإضافة مساحة أسفل حقل الإدخال -->
                            <input type="number" class="form-control" id="count" name="count" required>
                        </div>



                        <div class="col-6 text-end mb-3"> <!-- إضافة هامش أسفل العنصر -->
                            <button type="submit" class="btn bg-gradient-dark mb-0" href="javascript:;">
                                <i class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;انشاء باركود
                            </button>
                        </div>

                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




  @endsection
