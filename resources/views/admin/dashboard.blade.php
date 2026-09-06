@extends('admin.layouts.app')

    @section('styles')

		<!-- INTERNAL Select2 css -->
		<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css')}}"  rel="stylesheet">
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />

    @endsection

    @section('content')
					@if(session('success'))
						<div class="alert alert-success" id="Message">
							{{ session('success') }}
						</div>
					@endif
					@if(session('error'))
                        <div class="alert alert-danger" id="Message">
                            {{ session('error') }}
                        </div>
                    @endif

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
						<span class="main-content-title mg-b-0 mg-b-lg-1">DASHBOARD</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<!--<li class="breadcrumb-item active" aria-current="page">Sales</li>-->
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

				  <h1>Welcome, {{ Auth::guard('admins')->user()->name }}!</h1>


    @endsection

    @section('scripts')

		<!-- Internal Chart.Bundle js-->
		<script src="{{asset('assets/plugins/chartjs/Chart.bundle.min.js')}}"></script>

		<!-- Moment js -->
		<script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>

		<!-- INTERNAL Apexchart js -->
		<script src="{{asset('assets/js/apexcharts.js')}}"></script>

		<!--Internal Sparkline js -->
		<script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

		<!--Internal  index js -->
		<script src="{{asset('assets/js/index.js')}}"></script>

        <!-- Chart-circle js -->
		<script src="{{asset('assets/js/chart-circle.js')}}"></script>

		<!-- Internal Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

		<!-- INTERNAL Select2 js -->
		<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
		<script src="{{asset('assets/js/select2.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script>
            setTimeout(function(){
                document.getElementById('Message').style.display = 'none';
            }, 3000);
        </script>

<script>
  const qrScanner = new Html5Qrcode("reader");

  document.getElementById("scan-qr").addEventListener("click", function() {
    qrScanner.start({ facingMode: "environment" }, {
        fps: 10,
        qrbox: 450
    },
    (decodedText, decodedResult) => {
        qrScanner.stop();

        try {
            // Parse the JSON string from the QR code
            const data = JSON.parse(decodedText);

            // Extract values
            const uniqueCode = data.unique_code || '';
            const name = data.name || '';
            const refId = data.ref_id || '';
            const type = data.type || '';

            // Redirect with all the values as query parameters
            window.location.href = `/admin/submit-data?unique_code=${encodeURIComponent(uniqueCode)}&name=${encodeURIComponent(name)}&ref_id=${encodeURIComponent(refId)}&type=${encodeURIComponent(type)}`;
        } catch (error) {
            // Handle errors in parsing
            console.error("Parsing error:", error);
        }
    },
    (errorMessage) => {
        // Handle scanning errors
        console.error("Scanning error:", errorMessage);
    }).catch(err => {
        // Handle scanner initialization errors
        console.error("Scanner initialization failed:", err);
    });
  });
</script>







    @endsection
