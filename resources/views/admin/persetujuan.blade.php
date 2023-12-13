@extends('layouts.nav-admin')

@section('content')
<div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
    <div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dot mb-0">
          <li class="breadcrumb-item active" aria-current="page">Persetujuan Kelas Industri</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Photo Profile</th>
              <th>Nama</th>
              <th>Ketua Jurusan</th>
              <th>Email</th>
              <th>Deskripsi</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($guru as $i => $data)
              <tr>
                <th>{{ ++$i }}</th>
                <td>
                    <img src="{{ $data->poto_profile ?? asset('images/profiledefault.jpg') }}" alt="Photo profile Guru" width="70">
                </td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->jurusan->jurusan }}</td>
                <td>{{ $data->email }}</td>
                <td class="scroll-custome" style="max-width: 200px; overflow: auto">{{ $data->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                <td class="d-flex align-items-center gap-2">
                  {{-- Terima --}}
                  <form nameGuru="{{ $data->nama }}" jurusan="{{ $data->jurusan->jurusan }}" class="agree" action="{{ route('admin.acceptorreject', $data->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="status" value="1">
                    <button type="submit" class="btn btn-primary btn-icon"><i class="link-icon" data-feather="check"></i></button>
                  </form>
                  {{-- Tolak --}}
                  <form nameGuru="{{ $data->nama }}" jurusan="{{ $data->jurusan->jurusan }}" class="disagree" action="{{ route('admin.acceptorreject', $data->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="status" value="0">
                    <button type="submit" class="btn btn-danger btn-icon"><i class="link-icon" data-feather="x"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <p class="mt-3 mb-3 text-center fw-bold">Belum ada guru yang mendaftar</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3 align-items-center">
        {{-- {{ $industris->links('pagination::bootstrap-5') }} --}}
      </div>
    </div>
  </div>
    <script>
    if(document.querySelectorAll('.agree').length > 0){
    document.querySelectorAll('.agree').forEach(function(form) {
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        var nameGuru = form.getAttribute('nameGuru');
        var jurusan = form.getAttribute('jurusan');
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Ingin menyetujui guru '" + nameGuru + "' menjadi ketua jurusan '" + jurusan + "'?",
          icon: "question",
          showCancelButton: true,
          confirmButtonText: "Ya, Setujui!",
          cancelButtonText: "Batal",
          background: 'var(--bs-body-bg)',
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  }
    if(document.querySelectorAll('.disagree').length > 0){
    document.querySelectorAll('.disagree').forEach(function(form) {
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        var nameGuru = form.getAttribute('nameGuru');
        var jurusan = form.getAttribute('jurusan');
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Ingin menolak guru '" + nameGuru + "' menjadi ketua jurusan '" + jurusan + "'?",
          icon: "question",
          showCancelButton: true,
          confirmButtonText: "Ya, Tolak!",
          cancelButtonText: "Batal",
          background: 'var(--bs-body-bg)',
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  }
  </script>
@endsection
