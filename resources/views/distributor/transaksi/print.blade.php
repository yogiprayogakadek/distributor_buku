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
                            <th>Kode Transaksi</th>
                            <th>Distributor</th>
                            <th>Tanggal Transaksi</th>
                            <th>Status Pesanaan</th>
                            <th>Total</th>
                        </tr>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($transaksi as $transaksi)
                            @php
                                $total +=  $transaksi->total_pembayaran;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->distributor->nama_pt }}</td>
                                <td>{{ date_format(date_create($transaksi->tanggal_transaksi), 'd-m-Y') }}</td>
                                <td>{!! '<span class="badge bg-info">' . $transaksi->pembayaran->status_pembayaran . '</span>' !!}</td>
                                <td class="text-end">{{ convertToRupiah($transaksi->total_pembayaran) }}</td>
                                {{-- <td>{{ $transaksi->keterangan ?? '-' }}</td>
                                <td>{{ $transaksi->validator->nama ?? '-' }}</td> --}}
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-center">Total Keseluruhan</td>
                            <td class="text-end">
                                <strong><i>{{convertToRupiah($total)}}</i></strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
