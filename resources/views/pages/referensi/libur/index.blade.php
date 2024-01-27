{{-- Extends layout --}}
@extends('layout.default')

@section('content')
    <div class="panel-grid-libur">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">{{$page_title}}
                    </h3>
                </div>
                <div class="card-toolbar">
                   
                    @if ($accessMenu['add']=='true')
                    <!--begin::Button-->
                    <a class="btn btn-primary font-weight-bolder btn-add-libur">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <circle fill="#000000" cx="9" cy="15" r="6"/>
                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"/>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span> tambah</a>
                    <!--end::Button-->
                    @endif
                    
                </div>
            </div>
            <div class="card-body">
            
    
                <!--begin: Datatable-->
                <table class="table table-bordered" id="tbl_sys_libur">
                    <thead>
                        <tr>
                            <th >No.</th>
                            <th >Tanggal</th>
                            <th >Keterangan</th>
                            <th width="80px" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="panel-form-libur" style="display: none">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Form Hari Libur Nasional
                    </h3>
                </div>
                <div class="card-toolbar">
            
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:;" method="post" id="form-sys-libur" enctype="multipart/form-data">
                    <input type="hidden" name="CalendarID" id="CalendarID" value=""/>
                    <input type="hidden" name="Group" id="Group" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control input-sm">
                        </div>
                        <div class="col-sm-4">
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Keterangan <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="keterangan" id="keterangan" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <a class="btn btn-outline-primary font-weight-bolder btn-back-libur">
                            <i class="fas fa-angle-double-left"></i> Kembali
                        </a>
                        <button type="reset"  class="btn btn-default">Reset <i class="flaticon2-reload"></i></button>
                        <button type="submit"  class="btn btn-primary btn-save-form-libur">Simpan <i class="flaticon-paper-plane"></i></button>
                    </div>
                </form>
    
             
            </div>
        </div>
    </div>

@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script>
        const url_json = "referensi/liburnasional/ajax-data";
        const role_id = '{{auth()->user()->role_id}}';
    </script>
    <script src="{{asset('js/pages/crud/forms/widgets/bootstrap-daterangepicker.js') }}"></script>  
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/module/referensi/libur_nasional.js?random='.date('ymdHis')) }}" type="text/javascript"></script>

@endsection
{{-- Content --}}



