@extends('layouts.app')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="height: 50vh;">
        <div id="content">
            <form action="" onsubmit="event.preventDefault();generateUrl(this)">
                <select name="tipe" id="tipe">
                    <option value="rekap-daftar-hadir">Rekap daftar hadir</option>
                    <option value="rekap-absensi">Rekap absensi</option>
                </select>
                <div id="button-download">
                    <button type="submit">print</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const generateUrl = (form) => {
            console.log(form.target);
        }
    </script>
@endsection
