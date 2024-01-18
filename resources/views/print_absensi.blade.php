@extends('layouts.app')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="height: 50vh;">
        <div id="content">
            <form action="{{ route('cetak_rekap_absensi', $guru->id) }}" method="POST" class="d-flex flex-column align-items-center">
                @csrf
                <div class="d-flex">
                    <div class="form-group">
                        <select name="kelompok" class="form-control" id="tipe">
                            @forelse ($kelompok as $items)
                                <option value="{{ $items }}">{{ $items }}</option>
                            @empty
                                <option disabled>Kelompok tidak ada</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <select name="bulan" class="form-control" id="tipe">
                            @forelse ($dataBulan as $items)
                                <option value="{{ $items['bulan'] }}">{{ $items['nama_bulan'] }}</option>
                            @empty
                                <option disabled>Bulan tidak ada</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div id="button-download">
                    <link rel="stylesheet" href="{{ asset('css/button_download_print.css') }}">
                    <button type="submit" class="print-btn">
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
            </form>
        </div>
    </div>
@endsection
