{{-- Extends layout --}}
@extends('layout.default')

@section('content')
    <div class="panel-grid-supplier">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Kategori</h3>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-primary btn-sm mr-2 font-weight-bolder" data-toggle="modal" data-target="#ModalKategori">
                        <span class="flaticon-plus"></span> Tambah
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered" id="tbl_kategori">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th width="80px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop through categories and display data here --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages/kategori/form_kategori')
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
    <script src="{{ asset('js/module/kategori/kategori.js?random='.date('ymdHis')) }}" type="text/javascript"></script>
@endsection
{{-- Content --}}
