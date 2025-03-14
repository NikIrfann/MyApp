@extends('layout.admin')

@push('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Custom CSS for uniform button sizes -->
    <style>
        .btn-uniform {
            width: 100px;
            /* Adjust the width as needed */
            height: 38px;
            /* Adjust the height as needed to match the default button height */
            display: inline-block;
            text-align: center;
            vertical-align: middle;
        }

        /* Make text bold on row hover */
        .table-hover tbody tr:hover td {
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper mb-4">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customer List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mr-2">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Customer List</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <div class='container'>
            <a href="/customerAdd" class="btn btn-primary mb-4">Add New Customer</a>

            <div class="row g-3 align-items-center mt-2">
                <div class="col-auto">
                    <form action="/customer" method="GET">
                        <div class="input-group mb-3">
                            <input type="search" name="search" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('customer') }}" class="btn btn-outline-primary">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row col-auto">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            {{-- <th scope="col">No.</th> --}}
                            <th scope="col" class="text-center">Kg</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Phone No</th>
                            <th scope="col" class="text-center">Pick Up Time</th>
                            <th scope="col" class="text-center">Date</th>
                            <th scope="col" class="text-center">Price (RM)</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @php
                            $no = 1;
                        @endphp --}}

                        @foreach ($data as $index => $row)
                            <tr>
                                {{-- <th scope="row">{{ $index + $data->firstItem() }}</th> --}}
                                <td class="text-center">{{ $row->kg }}</td>
                                <td>{{ $row->name }}</td>
                                <td class="text-center">0{{ $row->phoneno }}</td>
                                <td class="text-center">{{ $row->pickuptime }}</td>
                                <td class="text-center">{{ $row->date }}</td>
                                <td class="text-center">{{ $row->kg * 12 }}</td>

                                <td class="text-center">
                                    <a href="{{ route('markCompleted', $row->id) }}"
                                        class="btn btn-success btn-uniform me-2">Completed</a>
                                    <a href="/editCustomer/{{ $row->id }}"
                                        class="btn btn-warning me-2 btn-uniform">Edit</a>
                                    <a href="#" class="btn btn-danger delete  btn-uniform"
                                        data-id="{{ $row->id }} " data-name="{{ $row->name }}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $data->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <script>
        $('.delete').click(function() {
            var customerId = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            swal({
                    title: "Are you sure?",
                    text: "You are trying to delete customer name " + name + "!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/deleteCustomer/" + customerId + ""
                        swal("Poof! The customer data has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        // swal("Your data has not been delete!");
                    }
                });
        });
    </script>

    <script>
        @if (Session::has('success'))
            // Configure Toastr options
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-right mb-5", // Change this to your preferred position
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            // Display a success toast, with a title
            toastr.success('{{ Session::get('success') }}')
        @endif
    </script>
@endpush
