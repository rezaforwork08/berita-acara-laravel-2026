@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold text-primary">Input Rekap Kehadiran (Bulk)</h5>
                <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary btn-sm">
                    Kembali ke Daftar
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('attendance.store') }}" method="POST" id="attendance-form">
                    @csrf
                    
                    @include('attendance.form')
                    
                    <hr class="my-4">
                    <div class="text-end">
                        <button type="reset" class="btn btn-light me-2 px-4 shadow-sm">Reset Form</button>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm" id="btn-save">
                            Simpan Data Kehadiran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('attendance-form').addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Silakan centang/pilih minimal 1 siswa untuk menyimpan data kehadirannya!');
        }
    });
</script>
@endsection
