{{-- Extends layout --}}
@extends('layout.default')

@section('content')
    <div class="panel-grid-dtl">
        <div class="card card-custom">
           
            <div class="card-body">
                 
                <div class="alert alert-warning">
                    <h4><b>Opps!</b> Maaf anda tidak diizinkan mengakses halaman ini !.</h4>
                </div>

            </div>
        </div>
    </div>


@endsection



{{-- Scripts Section --}}
@section('scripts')
    <script>
        const role_id = '{{auth()->user()->role_id}}';
    </script>
        
   
@endsection
{{-- Content --}}



