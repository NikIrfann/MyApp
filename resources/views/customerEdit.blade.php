@extends('layout.admin')

@section('content')
    <div class="content-wrapper mb-4">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Update Customer</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Update Customer</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <body>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="/updateCustomer/{{ $data->id }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Customer Name</label>
                                        <input required type="text" name="name" class="form-control" id="name"
                                            aria-describedby="emailHelp" value="{{ $data->name }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="kg" class="form-label">Kg</label>
                                        <input required type="text" name="kg" class="form-control" id="kg"
                                            aria-describedby="emailHelp" value="{{ $data->kg }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="phoneno" class="form-label">Phone Number</label>
                                        <input required type="text" name="phoneno" class="form-control" id="phoneno"
                                            aria-describedby="emailHelp" value="{{ $data->phoneno }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="pickuptime" class="form-label">Pickup Time</label>
                                        <select required name="pickuptime" class="form-select ml-2" id="pickuptime"
                                            aria-label="pickuptime">
                                            <option selected>{{ $data->pickuptime }}</option>
                                            <option value="1">AM</option>
                                            <option value="2">PM</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="datepicker" class="form-label">Date</label>
                                        <input required type="text" name="date" class="form-control" id="datepicker"
                                            value="{{ $data->date }}">
                                    </div>

                                    <button type="submit" class="btn btn-light">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </div>
@endsection


@push('scripts')
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script> --}}


    <!-- jQuery (full version) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#datepicker').datepicker({
                format: 'dd/mm/yyyy', // Set the format to display
                autoclose: true, // Close the datepicker after selection
            });
        });
    </script>
@endpush
