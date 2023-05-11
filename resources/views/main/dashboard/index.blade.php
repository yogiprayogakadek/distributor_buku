@extends('templates.master')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div id="main" style="width: 800px;height:700px;"></div>
                </div>
                <div class="card-footer">
                    {{--  --}}
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        // function getChartByKategori() {
        //     let label = [];
        //     let jumlah = [];
        //     $.ajax({
        //         type: "get",
        //         url: "/dashboard/chart-by-kategori",
        //         dataType: "json",
        //         success: function(response) {
        //             $.each(collection, function (index, value) {
        //                 label.push(value.nama_kategori)
        //                 jumlah.push(value.jumlah_transaksi)
        //             });
        //         },
        //         error: function(error) {
        //             console.log("Error", error);
        //         },
        //     });
        // }

        $(document).ready(function() {
            var arrayData = []
            $.ajax({
                type: "get",
                url: "/dashboard/chart-by-kategori",
                dataType: "json",
                success: function(response) {
                    $.each(response, function(i, v) {
                        arrayData.push({
                            value: parseInt(v.jumlah_transaksi),
                            name: v.nama_kategori
                        })
                    });

                    var totalPenjualan = 0;
                    var kategoriTerpopuler = '';
                    var penjualanTerbanyak = 0;
                    var kategoriKurangPopuler = '';
                    var penjualanTerendah = Infinity;
                    $.each(arrayData, function (i, data) {
                        totalPenjualan += data.value;

                        if(data.value > penjualanTerbanyak) {
                            penjualanTerbanyak = data.value;
                            kategoriTerpopuler = data.name;
                        }

                        if (data.value < penjualanTerendah) {
                            kategoriKurangPopuler = data.name;
                            penjualanTerendah = data.value;
                        }
                    });

                    let footer = '<span>Pada bulan ini total penjualan sebanyak <strong>'+ totalPenjualan + '</strong> dengan penjualan terbanyak dari kategori <strong>' + kategoriTerpopuler + '</strong> dengan total sebanyak <strong>' + penjualanTerbanyak + '</strong>. Sementara untuk penjualan terendah pada bulan ini yaitu buku dengan kategori <strong>'+ kategoriKurangPopuler +'</strong> dengan penjualan sebanyak <strong>'+penjualanTerendah+'<strong></span>';
                    $('.card-footer').append(footer)

                    // Initialize the echarts instance based on the prepared dom
                    var myChart = echarts.init(document.getElementById('main'));

                    // Specify the configuration items and data for the chart
                    var option = {
                        title: {
                            text: 'Penjualan Buku',
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
        });
    </script>
@endpush
