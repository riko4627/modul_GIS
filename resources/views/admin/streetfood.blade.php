@extends('layouts.master')
@section('title')
    streetfood
@endsection
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">streetfood</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary " id="myBtn">
                                <i class="fas fa-plus pr-2"></i>Tambah Data
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="streetfood" class="display table table-striped table-hover" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name Street Food</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="upsertDataModal" role="dialog" aria-labelledby="upsertDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl center" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="upsertDataModalLabel"><i class="fas fa-tasks pr-2"></i>Form Data</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="imagePreview" class="text-center mb-4">
                            <!-- Image preview will be inserted here -->
                        </div>
                        <form id="upsertDataForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_streetfoods">Name Steetfood</label>
                                        <input type="text" class="form-control" name="name_streetfoods"
                                            id="name_streetfoods" placeholder="Name Kedai">
                                        <small id="name_streetfoods-error" class="text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_streetfoods">Address</label>
                                        <textarea class="form-control" name="address_streetfoods" id="address_streetfoods" rows="3" placeholder="Address"></textarea>
                                        <small id="address_streetfoods-error" class="text-danger"></small>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_streetfoods">Telepon Number</label>
                                        <input type="text" class="form-control" name="phone_streetfoods"
                                            id="phone_streetfoods" placeholder="Number Telp">
                                        <small id="phone_streetfoods-error" class="text-danger"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="image_streetfoods">Image</label>
                                        <input type="file" class="form-control-file" name="image_streetfoods"
                                            id="image_streetfoods">
                                        <small id="image_streetfoods-error" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="simpanData">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#phone_streetfoods').on('input', function() {
                var input = $(this).val();
                if (!/^[0-9]*$/.test(input)) {
                    $(this).val(input.slice(0, -1));
                }
            });

            function getData() {
                $.ajax({
                    url: `/v1/streetfood`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        let tableBody = "";
                        $.each(response.data, function(index, item) {
                            tableBody += "<tr>";
                            tableBody += "<td>" + (index + 1) + "</td>";

                            tableBody += "<td>" + item.name_streetfoods + "</td>";
                            tableBody += "<td>" + item.address_streetfoods + "</td>";
                            tableBody += "<td>" + item.phone_streetfoods + "</td>";
                            tableBody += "<td><img src='/uploads/img-streetfoods/" + item
                                .image_streetfoods +
                                "' widht='100px' height='100px' alt='Streetfoods Image'></td>";
                            tableBody += "<td>";
                            tableBody +=
                                "<button type='button' class='btn btn-outline-primary btn-sm edit-btn' data-id='" +
                                item.id + "'><i class='fas fa-edit'></i></button>";
                            tableBody +=
                                "<button type='button' class='btn btn-outline-danger btn-sm delete-confirm' data-id='" +
                                item.id + "'><i class='fas fa-trash'></i></button>";
                            tableBody += "</td>";
                            tableBody += "</tr>";
                        });

                        $("#streetfood tbody").html(tableBody);
                        $('#streetfood').DataTable({
                            destroy: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            order: []
                        });
                    },
                    error: function() {
                        console.log("Gagal mengambil data dari server");
                    }
                });
            }



            getData();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // create
            $(document).on('click', '#simpanData', function(e) {
                $('.text-danger').text('');
                e.preventDefault();

                let id = $('#id').val();
                let formData = new FormData($('#upsertDataForm')[0]);
                let url = id ? `/v1/streetfood/update/${id}` : '/v1/streetfood/create';
                let method = id ? 'POST' : 'POST';

                loadingAllert();

                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        Swal.close();
                        if (response.code === 422) {
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                        } else if (response.code === 200) {
                            successAlert();
                            reloadBrowsers();
                        } else {
                            errorAlert();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.close();
                        errorAlert();
                    }
                });
            });

            // Edit data button click handler
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `/v1/streetfood/get/${id}`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#upsertDataModal').modal('show');

                        // Populate form fields with existing data
                        $('#id').val(response.data.id);
                        $('#name_streetfoods').val(response.data.name_streetfoods);
                        $('#address_streetfoods').val(response.data.address_streetfoods);
                        $('#phone_streetfoods').val(response.data.phone_streetfoods);

                        // Display image preview
                        if (response.data.image_streetfoods) {
                            $('#imagePreview').html(
                                `<img src="/uploads/img-streetfoods/${response.data.image_streetfoods}" widht="200px" height="200px" alt="Tailor Image">`
                            );
                        } else {
                            $('#imagePreview').html('<p>No image available</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data for edit:', error);
                    }
                });
            });

            // Delete data button click handler
            $(document).on('click', '.delete-confirm', function() {
                let id = $(this).data('id');

                // Function to delete data
                function deleteData() {
                    $.ajax({
                        type: 'DELETE',
                        url: `/v1/streetfood/delete/${id}`,
                        success: function(response) {
                            if (response.code === 200) {
                                successAlert();
                                reloadBrowsers();
                            } else {
                                errorAlert();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                // Show confirmation alert
                confirmAlert('Apakah Anda yakin ingin menghapus data?', deleteData);
            });


            // messeage alert
            // alert success message
            function successAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                })
            }

            // alert error message
            function errorAlert() {
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000,
                });
            }

            function reloadBrowsers() {
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }


            function confirmAlert(message, callback) {
                Swal.fire({
                    title: '<span style="font-size: 22px"> Konfirmasi!</span>',
                    html: message,
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya',
                    reverseButtons: true,
                    confirmButtonColor: '#48ABF7',
                    cancelButtonColor: '#EFEFEF',
                    customClass: {
                        cancelButton: 'text-dark'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }

            // loading alert
            function loadingAllert() {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            // reset modal
            $('#upsertDataModal').on('hidden.bs.modal', function() {
                $('.text-danger').text('');
                $('#upsertDataForm')[0].reset();
                $('#id').val('');
            });
            // event click btn create
            $(document).on('click', '#myBtn', function() {
                $('.text-danger').text('');
                $('#upsertDataForm')[0].reset();
                $('#id').val('');
                $('#upsertDataModal').modal('show');
                $('#imagePreview').html('');
            })





        });
    </script>
@endsection
