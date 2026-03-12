<div class="row mb-4 align-items-end">
    <div class="col-md-3">
        <label for="date" class="form-label fw-bold">Tanggal Kehadiran <span class="text-danger">*</span></label>
        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
    </div>
    <div class="col-md-9 text-end">
        <button type="button" class="btn btn-success px-4 shadow-sm" id="btn-present-all">
            Hadirkan Semua Terpilih
        </button>
    </div>
</div>

<div class="alert alert-info border-0 shadow-sm mb-4">
    <strong>Tips:</strong> Centang kotak di sebelah kiri nama siswa untuk mengubah status kehadirannya. Tombol "Hadirkan Semua Terpilih" akan langsung mengisi status <strong>Hadir</strong> dengan jam saat ini untuk semua siswa secara massal. Jika ingin memasukkan data yang khusus pada baris tertentu, Anda bisa memilih opsinya pada kolom status.
</div>

<div class="table-responsive shadow-sm rounded border">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th width="5%" class="text-center">
                    <div class="form-check d-flex justify-content-center m-0">
                        <input class="form-check-input" type="checkbox" id="check-all" title="Pilih Semua">
                    </div>
                </th>
                <th width="20%">Nama Siswa</th>
                <th width="15%">Status Masuk</th>
                <th width="12%">Jam Masuk</th>
                <th width="15%">Status Pulang</th>
                <th width="12%">Jam Pulang</th>
                <th width="21%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
            <tr class="student-row">
                <td class="text-center">
                    <div class="form-check d-flex justify-content-center m-0">
                        <input class="form-check-input student-checkbox" type="checkbox" name="attendances[{{ $index }}][student_id]" value="{{ $student->id }}" id="student_{{ $student->id }}">
                    </div>
                </td>
                <td>
                    <label for="student_{{ $student->id }}" class="mb-0 fw-semibold cursor-pointer d-block">
                        {{ $student->name }}
                    </label>
                </td>
                <td>
                    <select class="form-select status-in" name="attendances[{{ $index }}][status_in]" disabled>
                        <option value="">Pilih Status...</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Alpa">Alpa</option>
                    </select>
                </td>
                <td>
                    <input type="time" class="form-control check-in-time" name="attendances[{{ $index }}][check_in]" disabled>
                </td>
                <td>
                    <select class="form-select status-out" name="attendances[{{ $index }}][status_out]" disabled>
                        <option value="">Pilih Status...</option>
                        <option value="Pulang">Pulang</option>
                        <option value="Bolos">Bolos</option>
                        <option value="Izin Pulang Cepat">Izin Pulang Cepat</option>
                    </select>
                </td>
                <td>
                    <input type="time" class="form-control check-out-time" name="attendances[{{ $index }}][check_out]" disabled>
                </td>
                <td>
                    <input type="text" class="form-control note-input" name="attendances[{{ $index }}][note]" placeholder="Opsional..." disabled>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <div class="mb-3">Tidak ada data siswa ditemukan. <a href="{{ route('student.create') }}">Tambahkan siswa</a> terlebih dahulu.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .student-row.selected { background-color: rgba(13, 110, 253, 0.05); }
    .form-check-input { width: 1.25em; height: 1.25em; cursor: pointer; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('check-all');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const btnPresentAll = document.getElementById('btn-present-all');

    // Function to Enable or Disable form inputs inside the tr
    function toggleRowInputs(checkbox) {
        const row = checkbox.closest('tr');
        const inputs = row.querySelectorAll('select, input:not([type="checkbox"])');
        
        if (checkbox.checked) {
            row.classList.add('selected');
            inputs.forEach(input => input.disabled = false);
        } else {
            row.classList.remove('selected');
            inputs.forEach(input => {
                input.disabled = true;
                // Clear the value when disabled (unless it's something we might want to keep, like note)
                if (input.tagName === 'SELECT') {
                    input.value = '';
                } else if (input.type === 'time') {
                    input.value = '';
                }
            });
        }
    }

    // Assign event listeners
    studentCheckboxes.forEach(cb => {
        // Run once on load to initialize state
        toggleRowInputs(cb);
        
        cb.addEventListener('change', function() {
            toggleRowInputs(this);
            
            // Check if all are checked to update the "Select All" checkbox
            if (checkAll) {
                const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
                checkAll.checked = checkedCount === studentCheckboxes.length && studentCheckboxes.length > 0;
                checkAll.indeterminate = checkedCount > 0 && checkedCount < studentCheckboxes.length;
            }
        });
    });

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            const isChecked = this.checked;
            studentCheckboxes.forEach(cb => {
                cb.checked = isChecked;
                toggleRowInputs(cb);
            });
        });
    }

    if (btnPresentAll) {
        btnPresentAll.addEventListener('click', function() {
            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
            
            if (checkAll) {
                checkAll.checked = true;
                checkAll.indeterminate = false;
            }
            
            studentCheckboxes.forEach(cb => {
                // Check all checkboxes and enable row
                cb.checked = true;
                toggleRowInputs(cb);
                
                const row = cb.closest('tr');
                const statusIn = row.querySelector('.status-in');
                const checkInTime = row.querySelector('.check-in-time');
                
                if (statusIn) statusIn.value = 'Hadir';
                if (checkInTime && !checkInTime.value) checkInTime.value = timeString;
            });
        });
    }
});
</script>
