@extends('templates.master')

@section('title', 'Pengguna')
@section('sub-title', 'Laporan')

@section('content')
    <div class="row printableArea">
        <div class="col-md-12" style="text-align: center">
            <h2><strong>PT. PANUDUH ATMA WARAS</strong></h2>
            <h3>
                <b>Laporan Data Pengguna</b>
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Telp</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                        @foreach ($pengguna as $pengguna)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$pengguna->nama}}</td>
                                <td>{{$pengguna->email}}</td>
                                <td>{{$pengguna->username}}</td>
                                <td>{{$pengguna->telp}}</td>
                                <td>{{$pengguna->role}}</td>
                                <td>{!! $pengguna->is_active == true
                                    ? '<span class="badge bg-success">Aktif</span>'
                                    : '<span class="badge bg-danger">Tidak Aktif</span>' !!}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
