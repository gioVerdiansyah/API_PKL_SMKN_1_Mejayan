@extends('layouts.nav-kakomli')

@section('content')
    <div class="card p-4 mb-4 flex-md-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item active" aria-current="page">List data DuDi {{ $jurusan }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body pt-3">
            <p class="text-muted">Download Atau Cetak</p>
            <div class="d-flex justify-content-center">
                <link rel="stylesheet" href="{{ asset('css/button_download_docs.css') }}">
                <button class="download-button p-0 me-5" onclick="window.location.href = `{{ route('rekap_pendataan.dudi.download') }}`">
                    <div class="docs" style="padding: 11px 20px"><svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round"
                            fill="none" stroke-width="2" stroke="currentColor" height="20" width="20"
                            viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line y2="13" x2="8" y1="13" x1="16"></line>
                            <line y2="17" x2="8" y1="17" x1="16"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>List_DuDi_Jurusan_{{ $jurusan }}.pdf</div>
                    <div class="download">
                        <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none"
                            stroke-width="2" stroke="currentColor" height="24" width="24" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line y2="3" x2="12" y1="15" x1="12"></line>
                        </svg>
                    </div>
                </button>

                <link rel="stylesheet" href="{{ asset('css/button_download_print.css') }}">
                <button class="print-btn" onclick="window.open('{{ route('rekap_pendataan.dudi.print') }}', '_blank')">
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
            <p class="text-muted pt-3">Note: hasil print lebih bagus daripada download langsung</p>
        </div>
    </div>
@endsection
