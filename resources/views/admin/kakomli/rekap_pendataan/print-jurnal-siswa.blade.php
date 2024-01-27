@extends('layouts.nav-admin')

@section('content')
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/select2/select2.min.css') }}">
    <script src="{{ asset('cssAdmin/js/select2.js') }}"></script>
    <script src="{{ asset('cssAdmin/vendors/select2/select2.min.js') }}"></script>
    <div class="card p-4 mb-4 flex-md-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Siswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rekab Jurnal</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <form action="{{ route('admin.rekap_pendataan.print_jurnal_siswa') }}" method="POST">
            @csrf
            <div class="card-body pt-3 d-flex flex-column align-items-center">
                <p class="text-muted align-self-start">Cetak Jurnal siswa-siswi</p>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="list-siswa" class="form-label">Nama Siswa</label>
                        <select name="siswa" class="form-control" id="list-siswa">
                            @forelse ($siswa as $items)
                                <option value="{{ $items->id }}">{{ $items->name }}</option>
                            @empty
                                <option disabled>Tidak ada siswa</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bulan-bulan" class="form-label">Print jurnal pada bulan:</label>
                        <select name="bulan" class="form-control" id="bulan-bulan">
                            @forelse ($dataBulan as $items)
                                <option value="{{ $items['bulan'] }}">{{ $items['nama_bulan'] }}</option>
                            @empty
                                <option disabled>Bulan tidak ada</option>
                            @endforelse
                        </select>
                    </div>
                    <link rel="stylesheet" href="{{ asset('css/button_download_print.css') }}">
                    <button type="submit" class="print-btn mt-3">
                        <span class="printer-wrapper">
                            <span class="printer-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 92 75">
                                    <path stroke-width="5" stroke="black"
                                        d="M12 37.5H80C85.2467 37.5 89.5 41.7533 89.5 47V69C89.5 70.933 87.933 72.5 86 72.5H6C4.067 72.5 2.5 70.933 2.5 69V47C2.5 41.7533 6.75329 37.5 12 37.5Z">
                                    </path>
                                    <mask fill="white" id="path-2-inside-1_30_7">
                                        <path d="M12 12C12 5.37258 17.3726 0 24 0H57C70.2548 0 81 10.7452 81 24V29H12V12Z">
                                        </path>
                                    </mask>
                                    <path mask="url(#path-2-inside-1_30_7)" fill="black"
                                        d="M7 12C7 2.61116 14.6112 -5 24 -5H57C73.0163 -5 86 7.98374 86 24H76C76 13.5066 67.4934 5 57 5H24C20.134 5 17 8.13401 17 12H7ZM81 29H12H81ZM7 29V12C7 2.61116 14.6112 -5 24 -5V5C20.134 5 17 8.13401 17 12V29H7ZM57 -5C73.0163 -5 86 7.98374 86 24V29H76V24C76 13.5066 67.4934 5 57 5V-5Z">
                                    </path>
                                    <circle fill="black" r="3" cy="49" cx="78"></circle>
                                </svg>
                            </span>

                            <span class="printer-page-wrapper">
                                <span class="printer-page"></span>
                            </span>
                        </span>
                        Print
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#list-siswa').select2();
        });
    </script>
@endsection
