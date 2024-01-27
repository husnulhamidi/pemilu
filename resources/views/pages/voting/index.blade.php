{{-- Extends layout --}}
@extends('layout.default')

@section('content')
    <div class="panel-grid-supplier">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Perolehan Suara
                    </h3>
                </div>
                <div class="card-toolbar">

                    <a class="btn btn-primary btn-sm mr-2 font-weight-bolder btn-add-voting" data-toggle="modal" data-target="#AddVoting">
                        <span class="flaticon-plus"></span> 
                        Tambah
                    </a>
                   
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered" id="tbl_voting">
                    <thead>
                        <tr>
                            <th >No.</th>
                            <th >Kecamatan</th>
                            <th >Desa</th>
                            <th >Caleg</th>
                            <th >No. TPS</th>
                            <th >Jumlah Suara</th>
                            <th width="80px" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages/voting/modal_form')

@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script>
        const url_json = "";
        const role_id = '{{auth()->user()->role_id}}';
        $(document).ready(function() {
            $('.select2').select2();
             // currency format 
          
        });
    </script>
        
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/module/voting/voting.js?random='.date('ymdHis')) }}" type="text/javascript"></script>

@endsection
{{-- Content --}}



