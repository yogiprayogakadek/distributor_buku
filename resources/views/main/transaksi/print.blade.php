@extends('templates.master')

@section('title', 'Transaksi')
@section('sub-title', 'Laporan')

@section('content')
    <div class="row printableArea">
        <div class="col-md-12" style="text-align: center">
            <h2><strong>PT. PANUDUH ATMA WARAS</strong></h2>
            <h3>
                <b>Laporan Data Transaksi</b>
            </h3>
            <div class="pull-left py-5">
                <address>
                    <p class="m-t-30">
                        <img src="{{ asset('assets/images/web/favicon.ico') }}" height="100">
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
                            <th>Kode Pesanan</th>
                            <th>Distributor</th>
                            <th>Tanggal Pesanan</th>
                            <th>Status Pesanaan</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                            <th>Validator</th>
                        </tr>
                        @foreach ($transaksi as $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaksi->kode_pesanan }}</td>
                                <td>{{ $transaksi->distributor->user->nama }}</td>
                                <td>{{ $transaksi->tanggal_pesanan }}</td>
                                <td>{!! '<span class="badge bg-info">' . $transaksi->status_pesanan . '</span>' !!}</td>
                                <td>{{ convertToRupiah($transaksi->total) }}</td>
                                <td>{{ $transaksi->keterangan ?? '-' }}</td>
                                <td>{{ $transaksi->validator->nama ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
