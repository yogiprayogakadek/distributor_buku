@extends('templates.master')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}">
@endpush

@section('title', 'Dashboard')

@section('content')
    {{-- <div class="row">
        <div class="col-2"></div> --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white bg-opacity-75">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="awal" class="col-form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="awal" name="awal"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="akhir" class="col-form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="akhir" name="akhir"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="kategori" class="col-form-label">Filter</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="Kategori">Kategori</option>
                                <option value="Transaksi">Transaksi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label for="kategori" class="col-form-label" style="color: #8092ec;">Search</label>
                            <button class="btn btn-secondary btn-rounded btn-search">
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="main" style="width: 100%;height:700px;"></div>
                <div class="card-footer">
                    {{--  --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-2"></div>
    </div> --}}
@endsection



@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            const startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
            const endOfMonth = moment().endOf('month').format('YYYY-MM-DD');

            $('#awal').val(startOfMonth)
            $('#akhir').val(endOfMonth)

            function chartByKategori(awal, akhir, kategori)
            {
                $('.card-footer').empty()

                var arrayData = []
                $.ajax({
                    type: "POST",
                    url: "/dashboard/chart-by-kategori",
                    data: {
                        _token: "{{ csrf_token() }}",
                        awal: awal,
                        akhir: akhir,
                        kategori: kategori
                    },
                    success: function(response) {
                        $.each(response, function(i, v) {
                            arrayData.push({
                                value: parseInt(v.total),
                                name: v.kategori
                            })
                        });

                        var totalPenjualan = 0;
                        var kategoriTerpopuler = '';
                        var penjualanTerbanyak = 0;
                        var kategoriKurangPopuler = '';
                        var penjualanTerendah = Infinity;
                        $.each(arrayData, function(i, data) {
                            totalPenjualan += data.value;

                            if (data.value > penjualanTerbanyak) {
                                penjualanTerbanyak = data.value;
                                kategoriTerpopuler = data.name;
                            }

                            if (data.value < penjualanTerendah) {
                                kategoriKurangPopuler = data.name;
                                penjualanTerendah = data.value;
                            }
                        });

                        let footer = '<span>Pada bulan ini total penjualan sebanyak <strong>' +
                            totalPenjualan +
                            '</strong> dengan penjualan terbanyak dari kategori <strong>' +
                            kategoriTerpopuler + '</strong> dengan total sebanyak <strong>' +
                            penjualanTerbanyak +
                            '</strong>. Sementara untuk penjualan terendah pada bulan ini yaitu buku dengan kategori <strong>' +
                            kategoriKurangPopuler +
                            '</strong> dengan penjualan sebanyak <strong>' + penjualanTerendah +
                            '<strong></span>';
                        $('.card-footer').append(footer)

                        // Initialize the echarts instance based on the prepared dom
                        var myChart = echarts.init(document.getElementById('main'));

                        // Specify the configuration items and data for the chart
                        var option = {
                            title: {
                                text: (kategori == 'Kategori' ? 'Penjualan Buku' : 'Transaksi Buku'),
                                subtext: 'Berdasarkan kategori',
                                left: 'center'
                            },
                            tooltip: {
                                trigger: 'item'
                            },
                            legend: {
                                orient: 'vertical',
                                left: 'left'
                            },
                            series: [{
                                name: 'Kategori',
                                type: 'pie',
                                radius: '50%',
                                data: arrayData,
                                emphasis: {
                                    itemStyle: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
                            }]
                        };

                        // Display the chart using the configuration items and data just specified.
                        myChart.setOption(option);
                    },
                    error: function(error) {
                        console.log("Error", error);
                    },
                });
            }

            // initial first chart
            chartByKategori($('#awal').val(), $('#akhir').val(), 'Kategori')

            $('body').on('click', '.btn-search', function() {
                chartByKategori($('#awal').val(), $('#akhir').val(), $('select[name=kategori] option').filter(':selected').val())
            });




            // var myChart = echarts.init(document.getElementById('main'));

            // // Specify the configuration items and data for the chart
            // var option = {
            //     title: {
            //         text: 'ECharts Getting Started Example'
            //     },
            //     tooltip: {},
            //     legend: {
            //         data: ['sales']
            //     },
            //     xAxis: {
            //         data: ['Shirts', 'Cardigans', 'Chiffons', 'Pants', 'Heels', 'Socks']
            //     },
            //     yAxis: {},
            //     series: [{
            //         name: 'sales',
            //         type: 'bar',
            //         data: [5, 20, 36, 10, 10, 20]
            //     }]
            // };

            // // Display the chart using the configuration items and data just specified.
            // myChart.setOption(option);

            // $('body').on('click', '.btn-search', function() {
            //     let kategori = $('select[name=kategori] option').filter(':selected').val();
            //     if(kategori == 'Kategori') {
            //         $.ajax({
            //         type: "POST",
            //         url: "/dashboard/chart-by-kategori",
            //         data: {
            //             _token: "{{ csrf_token() }}",
            //             awal: awal,
            //             akhir: akhir,
            //             kategori: kategori
            //         },
            //         success: function(response) {
            //             $.each(response, function(i, v) {
            //                 arrayData.push({
            //                     value: parseInt(v.jumlah_transaksi),
            //                     name: v.nama_kategori
            //                 })
            //             });

            //             var totalPenjualan = 0;
            //             var kategoriTerpopuler = '';
            //             var penjualanTerbanyak = 0;
            //             var kategoriKurangPopuler = '';
            //             var penjualanTerendah = Infinity;
            //             $.each(arrayData, function(i, data) {
            //                 totalPenjualan += data.value;

            //                 if (data.value > penjualanTerbanyak) {
            //                     penjualanTerbanyak = data.value;
            //                     kategoriTerpopuler = data.name;
            //                 }

            //                 if (data.value < penjualanTerendah) {
            //                     kategoriKurangPopuler = data.name;
            //                     penjualanTerendah = data.value;
            //                 }
            //             });

            //             // Initialize the echarts instance based on the prepared dom
            //             var myChart = echarts.init(document.getElementById('main'));

            //             // Specify the configuration items and data for the chart
            //             var option = {
            //                 title: {
            //                     text: (kategori == 'Kategori' ? 'Penjualan Buku' : 'Transaksi Buku'),
            //                     subtext: 'Berdasarkan kategori',
            //                     left: 'center'
            //                 },
            //                 tooltip: {
            //                     trigger: 'item'
            //                 },
            //                 legend: {
            //                     orient: 'vertical',
            //                     left: 'left'
            //                 },
            //                 series: [{
            //                     name: 'Kategori',
            //                     type: 'pie',
            //                     radius: '50%',
            //                     data: arrayData,
            //                     emphasis: {
            //                         itemStyle: {
            //                             shadowBlur: 10,
            //                             shadowOffsetX: 0,
            //                             shadowColor: 'rgba(0, 0, 0, 0.5)'
            //                         }
            //                     }
            //                 }]
            //             };

            //             // Display the chart using the configuration items and data just specified.
            //             myChart.setOption(option);
            //         },
            //         error: function(error) {
            //             console.log("Error", error);
            //         },
            //     });
            //     }
            // });
        });
    </script>
@endpush
