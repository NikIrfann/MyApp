<!-- resources/views/completedOrders.blade.php -->

@extends('layout.admin')

@push('css')
    <!-- Add necessary CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* Make text bold on row hover */
        .table-hover tbody tr:hover td {
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper mb-4">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Completed Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mr-2">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Completed Orders</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class='container'>

            <div class="row g-3 align-items-center mt-2">
                <div class="col-auto">
                    <form action="{{ route('completedOrders') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="search" name="completedSearch" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('completedOrders') }}" class="btn btn-outline-primary">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if (empty($completedOrders))
                <div class="alert alert-success text-center" role="alert">
                    No Completed Orders
                </div>
            @else
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
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
                        @foreach ($completedOrders as $row)
                            <tr>
                                <td class="text-center">{{ $row->kg }}</td>
                                <td>{{ $row->name }}</td>
                                <td class="text-center">0{{ $row->phoneno }}</td>
                                <td class="text-center">{{ $row->pickuptime }}</td>
                                <td class="text-center">{{ $row->date }}</td>
                                <td class="text-center">{{ $row->kg * 12 }}</td>
                                <td class="text-center">
                                    <form action="{{ route('undoDelete', $row->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">Undo Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Add necessary scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    </script>
@endpush
