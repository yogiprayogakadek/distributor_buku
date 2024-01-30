<div class="modal fade" id="modalDistributor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white bg-opacity-75">
                <h5 class="modal-title" id="staticBackdropLabel">List Distributor</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-1">
                        <p>Kode Buku</p>
                    </div>
                    <div class="col-11 text-kode-buku"></div>

                    <div class="col-1">
                        <p>Judul Buku</p>
                    </div>
                    <div class="col-11 text-judul-buku"></div>

                    <div class="col-1">
                        <p>Stok Buku</p>
                    </div>
                    <div class="col-9 text-stok-buku"></div>
                    <div class="col-2 mb-2">
                        <button class="btn btn-outline-primary broadcast-button float-end" id="broadcastButton">
                            <i class="fas fa-broadcast-tower"></i> Distribusi Rata
                        </button>
                    </div>
                </div>
                <table class="table table-stripped table-bordered" id="tableDistributor">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center"><input type="checkbox" class="check-all-distributor"></th>
                            <th>Nama PT.</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="tbody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keluar</button>
                <button type="button" class="btn btn-primary btn-save-list" disabled>Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="card-title">Pilih kode buku</div>
            </div>
            <div class="col-6 text-end">
                <div class="card-options">
                    <button class="btn btn-primary btn-data" style="margin-left: 2px">
                        <i class="bx bx-arrow-back"></i> Data
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body need-complete" hidden>
        <div class="col-12 bg-danger text-white p-3">
            <h4 class="text-center text-italic">Mohon isikan semua buku pada setiap distributor / kolom yang tidak berwarna hijau</h4>
        </div>
    </div>
    <div class="card-body">
        <form id="formAdd">
            <div class="row">
                {{-- @foreach ($buku as $buku)
                <div class="col-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="kode_buku[]" value="{{json_decode($buku->data_buku, true)['kode_buku']}}" id="kodeBuku">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{json_decode($buku->data_buku, true)['kode_buku']}}
                        </label>
                    </div>
                </div>
                @endforeach --}}

                <div class="col-12">
                    <table class="table table-stripped table-bordered" id="tableBuku">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" class="check-all"></th>
                                <th>Kode Buku</th>
                                <th>Judul Buku</th>
                                <th>Distributor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buku as $buku)
                                <tr>
                                    <td class="text-center"><input class="form-check-input" type="checkbox"
                                            name="kode_buku[]"
                                            value="{{ json_decode($buku->data_buku, true)['kode_buku'] }}"
                                            id="kodeBuku"></td>
                                    <td class="kode-buku">{{ json_decode($buku->data_buku, true)['kode_buku'] }}</td>
                                    <td class="judul-buku">{{ json_decode($buku->data_buku, true)['judul'] }}</td>
                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-outline-light btn-primary btn-list-distributor" disabled
                                            data-stok="{{ $buku->stok_buku }}">
                                            <i class="fa fa-people-carry"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer text-end">
        <button class="btn btn-info btn-save pull-right" type="button" disabled>
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>
</div>

<script>

    $('.check-all').on('click', function() {
        if (this.checked) {
            $('.form-check-input').each(function() {
                this.checked = true;
                $(this).closest('tr').find('.btn-list-distributor').prop('disabled', false)
            });
        } else {
            $('.form-check-input').each(function() {
                this.checked = false;
                $(this).closest('tr').find('.btn-list-distributor').prop('disabled', true)
            });
        }

        if($('body').find('.row-color').length == $('body').find('.form-check-input:checked').length) {
            $('body').find('.btn-save').prop('disabled', false)
            $('body').find('.need-complete').prop('hidden', true)
        } else {
            $('body').find('.btn-save').prop('disabled', true)
            $('body').find('.need-complete').prop('hidden', false)
        }
    });

    $('.form-check-input').on('click', function() {
        if ($('.form-check-input:checked').length == $('.form-check-input').length) {
            $('.check-all').prop('checked', true);
        } else {
            $('.check-all').prop('checked', false);
        }

        if ($(this).prop('checked') == true) {
            $(this).closest('tr').find('.btn-list-distributor').prop('disabled', false)
        } else {
            $(this).closest('tr').find('.btn-list-distributor').prop('disabled', true)
        }

        if($('body').find('.row-color').length == $('body').find('.form-check-input:checked').length) {
            $('body').find('.btn-save').prop('disabled', false)
            $('body').find('.need-complete').prop('hidden', true)
        } else {
            $('body').find('.btn-save').prop('disabled', true)
            $('body').find('.need-complete').prop('hidden', false)
        }
    });

    var total = 0;
    // open the modal list distributor
    // $('body').on('click', '.btn-list-distributor', function() {
    //     $('#modalDistributor').modal('show')
    //     $('.check-all-distributor').prop('checked', false)

    //     // localStorage.clear();
    //     let stokBuku = $(this).data('stok')
    //     let judulBuku = $(this).closest('tr').find('td.judul-buku').text();
    //     let kodeBuku = $(this).closest('tr').find('td.kode-buku').text();

    //     localStorage.setItem('stok', stokBuku)
    //     localStorage.setItem('kodeBuku', kodeBuku)

    //     // set text
    //     $('#modalDistributor .text-kode-buku').html('<p>: ' + kodeBuku + '</p>')
    //     $('#modalDistributor .text-judul-buku').html('<p>: ' + judulBuku + '</p>')
    //     $('#modalDistributor .text-stok-buku').html('<p>: ' + stokBuku + ' eksemplar</p>')

    //     $.get("/distribusi/list-distributor", function(data) {
    //         $('body').find('.tbody').empty()
    //         $.each(data, function(index, value) {
    //             let tr_list = '<tr>' +
    //                 '<td class="text-center">' +
    //                 '<input class="check-distributor" type="checkbox" name="distributorId[]" value=' +
    //                 value.distributor.id + ' id="distribusiId">' + '</td>' +
    //                 '<td>' + value.distributor.nama_pt + '</td>' +
    //                 '<td>' +
    //                 '<input type="text" class="form-control jumlah" id="jumlah" disabled>' +
    //                 '</td>' +
    //                 '</tr>';

    //             $('#tableDistributor tbody').append(tr_list)
    //         });
    //     });
    // });

    // NEW
    // open the modal list distributor
    $('body').on('click', '.btn-list-distributor', function() {
        $('#modalDistributor').modal('show');
        $('.check-all-distributor').prop('checked', false);
        $('.btn-save-list').prop('disabled', true);

        let stokBuku = $(this).data('stok');
        let judulBuku = $(this).closest('tr').find('td.judul-buku').text();
        let kodeBuku = $(this).closest('tr').find('td.kode-buku').text();

        localStorage.setItem('stok', stokBuku);
        localStorage.setItem('kodeBuku', kodeBuku);

        $('#modalDistributor .text-kode-buku').html('<p>: ' + kodeBuku + '</p>');
        $('#modalDistributor .text-judul-buku').html('<p>: ' + judulBuku + '</p>');
        $('#modalDistributor .text-stok-buku').html('<p>: ' + stokBuku + ' eksemplar</p>');

        $.get("/distribusi/list-distributor", function(data) {
            $('body').find('.tbody').empty();
            $.each(data, function(index, value) {
                let tr_list = '<tr>' +
                    '<td class="text-center">' +
                    '<input class="check-distributor" type="checkbox" name="distributorId[]" value=' +
                    value.distributor.id + ' id="distribusiId-' + value.distributor.id + '">' +
                    '</td>' +
                    '<td>' + value.distributor.nama_pt + '</td>' +
                    '<td>' +
                    '<input type="text" class="form-control jumlah" id="jumlah-' + value
                    .distributor.id + '" disabled>' +
                    '</td>' +
                    '</tr>';

                $('#tableDistributor tbody').append(tr_list);
            });

            // Call the function to check checkboxes based on localStorage data
            checkCheckboxesFromLocalStorage();

            // Attach change event to checkboxes for enabling/disabling input
            $('.check-distributor').change(function() {
                let distributorId = $(this).val();
                let jumlahId = `#jumlah-${distributorId}`;
                let totalJumlah = calculateTotalJumlah();

                // Enable/disable input based on checkbox state
                $(jumlahId).prop('disabled', !$(this).prop('checked'));

                // Check if the total exceeds stok and adjust values
                if (totalJumlah > stokBuku) {
                    adjustJumlahValues();
                }
            });

            // Attach input event to jumlah fields to restrict input to numbers only
            $('.jumlah').on('input', function() {
                // Allow only numeric input
                $(this).val($(this).val().replace(/[^0-9]/g, ''));

                // Check if the total exceeds stok and adjust values
                let totalJumlah = calculateTotalJumlah();
                if (totalJumlah > stokBuku) {
                    adjustJumlahValues();
                }
            });

            // Function to calculate the total jumlah
            function calculateTotalJumlah() {
                let totalJumlah = 0;
                $('.jumlah:enabled').each(function() {
                    totalJumlah += parseInt($(this).val()) || 0;
                });
                return totalJumlah;
            }

            // Function to adjust jumlah values if the total exceeds stok
            function adjustJumlahValues() {
                let totalJumlah = calculateTotalJumlah();
                let remainingStok = stokBuku - totalJumlah;

                // Get the count of enabled input fields
                let enabledInputs = $('.jumlah:enabled');
                let enabledCount = enabledInputs.length;

                // Adjust values to not exceed stok
                enabledInputs.each(function(index) {
                    let currentInput = $(this); // Capture the current input element

                    let currentValue = parseInt(currentInput.val()) || 0;

                    // Ensure adjusted value is not negative and distribute remaining stok to subsequent fields
                    let adjustedValue = Math.max(0, Math.min(currentValue, remainingStok));
                    currentInput.val(adjustedValue);
                    remainingStok -= adjustedValue;

                    // If there is remaining stok after distributing to previous fields,
                    // distribute the remaining stok evenly among subsequent fields
                    if (index === enabledCount - 1 && remainingStok > 0) {
                        let additionalPerField = Math.floor(remainingStok / (enabledCount -
                            index));
                        let remainder = remainingStok % (enabledCount - index);

                        enabledInputs.slice(index + 1).each(function(subIndex) {
                            let additionalValue = additionalPerField + (subIndex <
                                remainder ? 1 : 0);
                            let newValue = parseInt(currentInput.val()) +
                                additionalValue;
                            currentInput.val(newValue);
                            remainingStok -= additionalValue;
                        });
                    }
                });

            }


        });
    });

    // Function to check checkboxes based on localStorage data
    function checkCheckboxesFromLocalStorage() {
        let kodeBuku = localStorage.getItem('kodeBuku');
        let listDistributor = localStorage.getItem('listDistributor');

        if (kodeBuku && listDistributor) {
            let dataArray = JSON.parse(listDistributor);
            let existingData = dataArray.find(item => item.kodeBuku === kodeBuku);

            if (existingData && Array.isArray(existingData.data)) {
                existingData.data.forEach(data => {
                    let distributorId = data.distributorId;
                    let jumlah = data.jumlah;

                    let checkboxId = `distribusiId-${distributorId}`;
                    let jumlahId = `jumlah-${distributorId}`;

                    $(`#${checkboxId}`).prop('checked', true);
                    $(`#${jumlahId}`).val(jumlah).prop('disabled', false);
                });
            }
        }
    }

    // END

    // NEW for distribute
    function distributeEvenly() {
        // Get the total number of enabled input fields
        let enabledInputs = $('.jumlah:enabled');
        let enabledCount = enabledInputs.length;

        // Get the available stock
        let availableStock = localStorage.getItem('stok');

        // Calculate the even distribution per input field
        let distributionPerField = Math.floor(availableStock / enabledCount);
        let remainder = availableStock % enabledCount;

        // Set the values for each enabled input field
        enabledInputs.each(function(index) {
            let additionalCopies = (index < remainder) ? 1 : 0;
            let distributedValue = distributionPerField + additionalCopies;

            $(this).val(distributedValue);
        });
    }

    // Call the function when the button with id "btn-save-list" is clicked
    $('#btn-save-list').on('click', function() {
        highlightRowsBasedOnLocalStorage();
    });


    $('#broadcastButton').on('click', function() {
        if ($('.check-all-distributor').prop('checked') == false) {
            $('.check-all-distributor').click()
        }
        distributeEvenly();
    });

    // END

    $('.check-all-distributor').on('click', function() {
        if (this.checked) {
            $('.check-distributor').each(function() {
                this.checked = true;
                $('.btn-save-list').prop('disabled', false);
                $(this).closest('tr').find('.jumlah').prop('disabled', false)
            });
        } else {
            $('.check-distributor').each(function() {
                this.checked = false;
                $('.btn-save-list').prop('disabled', true);
                $(this).closest('tr').find('.jumlah').prop('disabled', true)
            });
        }
    });

    $('body').on('click', '.check-distributor', function() {
        if ($('.check-distributor:checked').length == $('.check-distributor').length) {
            $('.btn-save-list').prop('disabled', false);
        } else {
            $('.check-all-distributor').prop('checked', false);
        }

        if ($(this).prop('checked') == true) {
            $(this).closest('tr').find('.jumlah').prop('disabled', false)
        } else {
            $(this).closest('tr').find('.jumlah').prop('disabled', true)
        }

        if ($('.check-distributor:checked').length > 0) {
            $('.btn-save-list').prop('disabled', false);
        } else {
            $('.btn-save-list').prop('disabled', true);
        }
    });

    // New Highlight
    function highlightRowsBasedOnLocalStorage() {
        // Retrieve the localStorage data
        let localStorageData = JSON.parse(localStorage.getItem('listDistributor'));

        // Iterate through each table row
        $('#tableBuku tbody tr').each(function(index, row) {
            // Get the kodeBuku for the current row
            let kodeBuku = $(row).find('.kode-buku').text().trim();

            // Find the corresponding data in localStorage
            let localStorageItem = localStorageData.find(item => item.kodeBuku === kodeBuku);

            // If a match is found, change the row color
            if (localStorageItem) {
                $(row).addClass('row-color');
            }
        });
    }
    // end

    $('body').on('click', '.btn-save-list', function() {
        let kodeBuku = localStorage.getItem('kodeBuku');

        // Retrieve existing listDistributor from localStorage or create an empty array
        let listDistributor = localStorage.getItem('listDistributor') ? JSON.parse(localStorage.getItem(
            'listDistributor')) : [];

        let dataArray = listDistributor && Array.isArray(listDistributor) ? listDistributor : [];

        // Check if there is existing data for the same kodeBuku
        let existingDataIndex = dataArray.findIndex(item => item.kodeBuku === kodeBuku);

        if (existingDataIndex !== -1) {
            // If existing data found, update it
            dataArray[existingDataIndex].data = [];
            $('.check-distributor:checked').each(function() {
                let jumlah = $(this).closest('tr').find('input.jumlah').val();
                let distributorId = $(this).val();

                let data = {
                    'jumlah': parseInt(jumlah),
                    'distributorId': parseInt(distributorId),
                };

                dataArray[existingDataIndex].data.push(data);
            });
        } else {
            // If no existing data, add new entry
            let newData = {
                'kodeBuku': kodeBuku,
                'data': []
            };

            $('.check-distributor:checked').each(function() {
                let jumlah = $(this).closest('tr').find('input.jumlah').val();
                let distributorId = $(this).val();

                let data = {
                    'jumlah': parseInt(jumlah),
                    'distributorId': parseInt(distributorId),
                };

                newData.data.push(data);
            });

            dataArray.push(newData);
        }

        // Update the listDistributor in localStorage
        localStorage.setItem('listDistributor', JSON.stringify(dataArray));
        highlightRowsBasedOnLocalStorage();

        // enable save button
        if($('body').find('.row-color').length == $('body').find('.form-check-input:checked').length) {
            $('body').find('.btn-save').prop('disabled', false)
            $('body').find('.need-complete').prop('hidden', true)
        } else {
            $('body').find('.btn-save').prop('disabled', true)
            $('body').find('.need-complete').prop('hidden', false)
        }

        $('#modalDistributor').modal('hide');
        Swal.fire('Info', 'Simpan sementara', 'success');
    });
</script>
