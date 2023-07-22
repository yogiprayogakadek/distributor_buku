function getData() {
    $.ajax({
        type: "get",
        url: "/pengguna/render",
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

    // print data
    $("body").on("click", ".btn-print", function () {
        Swal.fire({
            title: "Cetak data pengguna?",
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
                    popTitle: "LaporanDataPengguna",
                    popOrient: "landscape",
                };
                $.ajax({
                    type: "GET",
                    url: "/pengguna/print/",
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

    $("body").on("change", ".status", function () {
        let status = $("select[name=status] option").filter(":selected").val();
        let user_id = $(this).data("id");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: "/pengguna/update",
            data: {
                id: user_id,
                status: status,
            },
            success: function (response) {
                getData();
                Swal.fire(response.title, response.message, response.status);
            },
        });
    });
});
