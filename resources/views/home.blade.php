@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h4 class="text-center" id="clock"
                        style="font-size: 2.5rem; font-weight: bold; color: #333; text-shadow: 2px 2px 4px rgba(0,0,0,0.1); padding: 20px; background: linear-gradient(to right, #f8f9fa, #e9ecef); border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    </h4>
                </div>
            </div>
            @livewire('fishpond-card-list')
            @livewire('temperature-history-table-list')
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        function updateClock() {
            const now = new Date();
            // Format the date and time in a more readable format
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('clock').innerHTML = now.toLocaleString('en-US', options);
            setTimeout(updateClock, 1000);
        }
        updateClock();

        // // Auto refresh Livewire components every 5 seconds
        // setInterval(() => {
        //     Livewire.dispatch('refresh');
        //     console.log('ASDADASD');
        // }, 5000);
    </script>
@endsection
