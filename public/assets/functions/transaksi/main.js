function getData() {
    $.ajax({
        type: "get",
        url: "/transaksi/render",
        dataType: "json",
        success: function (response) {
            $(".render").html(response.data);
        },
        error: function (error) {
            console.log("Error", error);
        },
    });
}

$(document).ready(function () {
    getData();

    let fill =
        '<label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>' +
        '<div class="col-md-10">' +
        '<textarea class="form-control keterangan" id="keterangan" name="keterangan" rowspan="5"></textarea>' +
        '<div class="invalid-feedback error-keterangan"></div>' +
        "</div>";

    $("body").on("click", ".btn-pembayaran", function () {
        let status = $(this).closest('tr').find('td.status-pembayaran').text()
        let id = $(this).data("id");
        let buktiPembayaran = $(this).data('pembayaran');

        $("#modal").modal("show");
        $('#modal .status').val(status)
        $('#modal .id').val(id)
        $('#modal .bukti-pembayaran').html('<a href=' + assets(buktiPembayaran) + ' style="text-decoration: none; font-style: italic" target="_blank">Lihat bukti pembayaran</a>')
    });

    // on update button
    $("body").on("click", ".btn-save", function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        let form = $("#formUpdatePembayaran")[0];
        let data = new FormData(form);
        $.ajax({
            type: "POST",
            url: "/transaksi/update",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $(".btn-save").attr("disable", "disabled");
                $(".btn-save").html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                $(".btn-save").removeAttr("disable");
                $(".btn-save").html("Simpan");
            },
            success: function (response) {
                $("#modal").modal("hide");
                getData();
                Swal.fire(response.title, response.message, response.status);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $("body").on("click", ".btn-detail", function () {
        let id = $(this).data("id");
        $("#modalTransaksi").modal("show");

        $("#tableDetail tbody").empty();
        $(".grand-total").empty();
        $.get("/transaksi/detail/" + id, function (data) {
            let grandTotal = 0;
            $.each(data, function (index, value) {
                let tr_list =
                    "<tr class='text-center'>" +
                    "<td>" +
                    (index + 1) +
                    "</td>" +
                    "<td>" +
                    value.nama_kategori +
                    "</td>" +
                    "<td>" +
                    value.judul +
                    "</td>" +
                    "<td>" +
                    value.penerbit +
                    "</td>" +
                    "<td>" +
                    value.penulis +
                    "</td>" +
                    "<td class='text-end'>" +
                    convertToRupiah(value.harga) +
                    "</td>" +
                    "<td>" +
                    value.kuantitas +
                    "</td>" +
                    "<td class='text-end'>" +
                    convertToRupiah(value.kuantitas * value.harga) +
                    "</td>" +
                    "</tr>";

                grandTotal += value.kuantitas * value.harga;

                $("#tableDetail tbody").append(tr_list);
            });
            $(".grand-total").text(convertToRupiah(grandTotal));
        });
    });

    $("body").on("click", ".btn-print", function () {
        Swal.fire({
            title: "Cetak data transaksi?",
            text: "Laporan akan dicetak",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, cetak!",
        }).then((result) => {
            if (result.value) {
                var mode = "iframe"; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close,
                    popTitle: "LaporanDataTransaksi",
                    // popOrient: "landscape",
                };
                $.ajax({
                    type: "GET",
                    url: "/transaksi/print/",
                    dataType: "json",
                    success: function (response) {
                        document.title =
                            "PT. PANUDUH ATMA WARAS | Distribusi Buku - Print" +
                            new Date().toJSON().slice(0, 10).replace(/-/g, "/");
                        $(response.data)
                            .find("div.printableArea")
                            .printArea(options);
                    },
                });
            }
        });
    });
});
