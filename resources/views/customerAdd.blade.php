@extends('layout.admin')

@section('content')
    <div class="content-wrapper mb-4">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add New Customer</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Add New Customer</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <body>
            <h1 class="text-center mb-4">Add Customer</h1>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="/insertNewCustomer" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Customer Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            aria-describedby="nameHelp" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="kg" class="form-label">Kg</label>
                                        <input type="text" name="kg" class="form-control" id="kg"
                                            aria-describedby="kgHelp" value="{{ old('kg') }}">
                                        @error('kg')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phoneno" class="form-label">Phone Number</label>
                                        <input type="text" name="phoneno" class="form-control" id="phoneno"
                                            aria-describedby="phonenoHelp" value="{{ old('phoneno') }}">
                                        @error('phoneno')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="pickuptime" class="form-label">Pickup Time</label>
                                        <input type="text" name="pickuptime" class="form-control" id="pickuptime"
                                            aria-describedby="pickuptimeHelp" value="{{ old('pickuptime') }}">
                                        @error('pickuptime')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="datepicker" class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control" id="datepicker"
                                            value="{{ old('date') }}">
                                        @error('date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection


@push('scripts')
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <!-- jQuery (full version) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Bootstrap Timepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <script>
        $(document).ready(function() {
            // $('#datepicker').datepicker({
            //     format: 'dd/mm/yyyy', // Set the format to display
            //     autoclose: true, // Close the datepicker after selection
            // });

            $('#pickuptime').timepicker({
                timeFormat: 'h:mm p',
                interval: 60,
                minTime: '7:00am',
                maxTime: '11:00pm',
                defaultTime: '8:00am',
                // startTime: '12:00am',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        });
    </script>

    </body>
@endpush
