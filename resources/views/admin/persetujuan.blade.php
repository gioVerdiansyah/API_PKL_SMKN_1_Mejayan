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
              <th>Alamat</th>
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
                  <form class="formTerima" action="" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit" class="btn btn-primary btn-icon"><i class="link-icon" data-feather="check"></i></button>
                  </form>
                  {{-- Tolak --}}
                  <form class="formTolak" action="" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-icon"><i class="link-icon" data-feather="x"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <p class="mt-3 mb-3 text-center fw-bold">Tidak Ada Permintaan Pendaftaran Kelas Industri</p>
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
@endsection
