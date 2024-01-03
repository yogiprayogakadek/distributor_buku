@extends('templates.master')

@section('title', 'Pembayaran')
@section('sub-title', 'Laporan')

@section('content')
    <div class="row printableArea">
        <div class="col-md-12" style="text-align: center">
            <h2><strong>PT. PANUDUH ATMA WARAS</strong></h2>
            <h3>
                <b>Laporan Data Pembayaran</b>
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
                            <th>Kode Pesanan</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Jenis Pembayaran</th>
                            <th>Bukti Pembayaran</th>
                            <th>Total Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Validator</th>
                            <th>Keterangan</th>
                        </tr>
                        @foreach ($pembayaran as $pembayaran)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pembayaran->transaksi->kode_pesanan }}</td>
                                <td>{{ $pembayaran->tanggal_pembayaran }}</td>
                                <td>{{ $pembayaran->jenis_pembayaran }}</td>
                                <td>
                                    @if ($pembayaran->bukti_pembayaran != null)
                                        <a href="{{ asset($pembayaran->bukti_pembayaran) }}" target="_blank">
                                            <img src="{{ asset($pembayaran->bukti_pembayaran) }}" height="70px">
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ convertToRupiah($pembayaran->transaksi->total) }}</td>
                                <td>{!! '<span class="badge bg-info">' . $pembayaran->status_pembayaran . '</span>' !!}</td>
                                <td>{{ $pembayaran->validator->nama ?? '-' }}</td>
                                <td>{{ $pembayaran->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
