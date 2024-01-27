{{-- Extends layout --}}
@extends('layout.default')

@section('content')
    <div class="panel-grid-supplier">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Supplier
                    </h3>
                </div>
                <div class="card-toolbar">
                
                    <a class="btn btn-primary btn-sm mr-2 font-weight-bolder" data-toggle="modal" data-target="#AddSupplier">
                        <span class="flaticon-plus"></span> 
                        Tambah
                    </a>
                   
                </div>
            </div>
            <div class="card-body">
            
    
                <!--begin: Datatable-->
                <table class="table table-bordered" id="tbl_supplier">
                    <thead>
                        <tr>
                            <th >No.</th>
                            <th >Supplier</th>
                            <th >Telp</th>
                            <th >Alamat</th>
                            <th >No. Rekening</th>
                            <th >Nama Rekening</th>
                            <th >Bank</th>
                            <th width="80px" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages/supplier/modal_form_supplier')

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
    </script>
        
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/module/supplier/supplier.js?random='.date('ymdHis')) }}" type="text/javascript"></script>

@endsection
{{-- Content --}}



