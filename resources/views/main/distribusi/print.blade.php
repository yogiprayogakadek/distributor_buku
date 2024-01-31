@extends('templates.master')

@section('title', 'Buku')
@section('sub-title', 'Laporan')

@section('content')
    <div class="row printableArea">
        <div class="col-md-12" style="text-align: center">
            <h2><strong>PT. PANUDUH ATMA WARAS</strong></h2>
            <h3>
                <b>Laporan Data Buku</b>
            </h3>
            <div class="pull-left py-5">
                <address>
                    <p class="m-t-30">
                        <img src="{{ asset('assets/images/web/logo_pt.png') }}" height="100">
                    </p>
                    <p class="m-t-30">
                        <b>Dicetak oleh :</b>
                        <i class="fa fa-user"></i> {{ auth()->user()->nama }}
                    </p>
                    <p class="m-t-30">
                        <b>Tanggal Laporan :</b>
                        <i class="fa fa-calendar"></i> {{ date('d-m-Y') }}
                    </p>
                </address>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" role="grid"
                        id="tableData">
                        {{-- <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Penerbit</th>
                            <th>Penulis</th>
                            <th>Tahun Terbit</th>
                            <th>Harga</th>
                            <th>Foto</th>
                            <th>Stok Buku</th>
                            <th>Status</th>
                        </tr>
                        @foreach ($buku as $buku)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $buku->kategori->nama }}</td>
                                <td>{{ json_decode($buku->data_buku, true)['kode_buku'] }}</td>
                                <td>{{ json_decode($buku->data_buku, true)['judul'] }}</td>
                                <td>{{ json_decode($buku->data_buku, true)['penerbit'] }}</td>
                                <td>{{ json_decode($buku->data_buku, true)['penulis'] }}</td>
                                <td>{{ json_decode($buku->data_buku, true)['tahun_terbit'] }}</td>
                                <td>{{ convertToRupiah(json_decode($buku->data_buku, true)['harga']) }}</td>
                                <td><img src="{{ json_decode($buku->data_buku, true)['foto'] }}" width="70px"></td>
                                <td>{{ $buku->stok_buku }}</td>
                                <td>{!! $buku->status == true ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>' !!}</td>
                            </tr>
                        @endforeach --}}

                        <tr>
                            <th class="text-center align-middle" rowspan="2">No</th>
                            <th class="text-center align-middle" rowspan="2">Tanggal Distribusi</th>
                            <th class="text-center" colspan="7">Data</th>
                        </tr>
                        <tr>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Penerbit</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Status</th>
                        </tr>
                        @foreach ($distribusi as $item)
                            @foreach (json_decode($item->data_buku, true) as $key => $detail)
                            @php
                                $relatedBukuDetail = $relatedBuku->filter(function ($buku) use ($detail) {
    return json_decode($buku->data_buku, true)['kode_buku'] == $detail['kode_buku'];
})->first();
                                // dd($relatedBuku);
                                // dd($relatedBukuDetail);
                            @endphp
                                <tr>
                                    @if ($loop->first)
                                        <td class="text-center align-middle" rowspan="{{ count(json_decode($item->data_buku, true)) }}">{{ $loop->parent->iteration }}
                                        </td>
                                        <td class="text-center align-middle" rowspan="{{ count(json_decode($item->data_buku, true)) }}">{{date_format(date_create($item->tanggal_distribusi), 'd-m-Y')}}</td>
                                    @endif
                                    <td>{{$detail['kode_buku']}}</td>
                                    {{-- <td>{{$detail->judul}}</td> --}}
                                    <td>{{json_decode($relatedBukuDetail->data_buku, true)['judul']}}</td>
                                    <td>{{json_decode($relatedBukuDetail->data_buku, true)['penerbit']}}</td>
                                    <td>{{convertToRupiah(json_decode($relatedBukuDetail->data_buku, true)['harga'])}}</td>
                                    <td>{{$detail['kuantitas']}} eksemplar</td>
                                    <td>{{ ($detail['updated_at'] == null ? 'Belum di terima' : ($detail['status'] == true ? 'Diterima (' . $detail['updated_at'] .')' : 'Dibatalkan') ) }}</td>
                                    {{-- <td>{{$detail['status'] == true ? 'Diterima' : 'Ditolak'}}</td> --}}
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- <tr>
    <th class="text-center align-middle" rowspan="2">No</th>
    <th class="text-center align-middle" rowspan="2">Tanggal Distribusi</th>
    <th class="text-center" colspan="7">Data</th>
</tr>
<tr>
    <th>Kode Buku</th>
    <th>Judul Buku</th>
    <th>Penerbit</th>
    <th>Harga</th>
    <th>Kuantitas</th>
    <th>Status</th>
</tr>
<tr>
    <td rowspan="2">1</td>
    <td rowspan="2">31 Januari 2024</td>
    <td>A001</td>
    <td>Aku  Bukan Siapa Dan Aku Tidak Punya Nama</td>
    <td>Gramedia Pustaka Utama</td>
    <td>Rp. 50.000,-</td>
    <td>10 eksemplar</td>
    <td>Dikirim</td>
</tr>
<tr>
    <td>A002</td>
    <td>Kamu uhuyy</td>
    <td>Gramedia Pustaka Utama</td>
    <td>Rp. 60.000,-</td>
    <td>20 eksemplar</td>
    <td>Dikirim</td>
</tr> --}}
