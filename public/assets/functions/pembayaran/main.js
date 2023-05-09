function getData() {
    $.ajax({
        type: "get",
        url: "/pembayaran/render",
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

    $("body").on("click", ".btn-edit", function () {
        let status = $(this).data("status");
        let keterangan = $(this).data("keterangan");
        let id = $(this).data("id");

        $("#modal").modal("show");
        $(".status").val(status);
        $(".id").val(id);
        $(".btn-save").prop("disabled", true);

        if (status == "Ditolak") {
            $(".group-keterangan").append(fill);
            $(".keterangan").val(keterangan);
        }
    });

    $("body").on("change", ".status", function () {
        let value = $("select[name=status] option").filter(":selected").val();

        if (value == "Ditolak") {
            $(".group-keterangan").append(fill);

            // Invalid
            $(".keterangan").addClass("is-invalid");
            $(".error-keterangan").text("Keterangan tidak boleh kosong");
            $(".btn-save").prop("disabled", true);
        } else {
            $(".group-keterangan").html("");
            $(".btn-save").prop("disabled", false);
        }
    });

    $("body").on("keyup", ".keterangan", function () {
        let value = $(this).val();
        if (value.length > 0) {
            $(".keterangan").removeClass("is-invalid");
            $(".error-keterangan").text("");

            $(".btn-save").prop("disabled", false);
        } else {
            // Invalid
            $(".keterangan").addClass("is-invalid");
            $(".error-keterangan").text("Keterangan tidak boleh kosong");
            $(".btn-save").prop("disabled", true);
        }
    });

    // on update button
    $("body").on("click", ".btn-save", function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        let form = $("#formPesanan")[0];
        let data = new FormData(form);
        $.ajax({
            type: "POST",
            url: "/pembayaran/update",
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
});
