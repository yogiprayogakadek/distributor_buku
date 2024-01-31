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
                        <tr>
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
                                <td class="text-end">{{ convertToRupiah(json_decode($buku->data_buku, true)['harga']) }}</td>
                                <td><img src="{{ json_decode($buku->data_buku, true)['foto'] }}" width="70px"></td>
                                <td>{{ $buku->stok_buku }}</td>
                                <td>{!! $buku->status == true ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>' !!}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

