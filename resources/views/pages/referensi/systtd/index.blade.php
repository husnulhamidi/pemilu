{{-- Extends layout --}}
@extends('layout.default')

@section('content')
    <div class="panel-grid-ttd">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Setting TTd PLH
                    </h3>
                </div>
                <div class="card-toolbar">
                   
                    @if ($accessMenu['add']=='true')
                    <!--begin::Button-->
                    <a class="btn btn-primary font-weight-bolder btn-add-ttd">
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
                <table class="table table-bordered" id="tbl_sys_ttd">
                    <thead>
                        <tr>
                            <th >No.</th>
                            <th >Ket</th>
                            <th >Nama</th>
                            <th >Jabatan</th>
                            <th >Status</th>
                            <th width="80px" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="panel-form-ttd" style="display: none">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Form Setting TTD
                    </h3>
                </div>
                <div class="card-toolbar">
            
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:;" method="post" id="form-sys-ttd" enctype="multipart/form-data">
                    <input type="hidden" name="ttdID" id="ttdID" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Verifikator <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select name="jenis_verifikator" id="jenis_verifikator" class="form-control" style="width:100%">
                                <option value="">-- Pilih  --</option>
                                <option value="Mengetahui">Mengetahui</option>
                                <option value="Menyetujui">Menyetujui</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="nama_ttd" id="nama_ttd" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jabatan <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="jabatan_ttd" id="jabatan_ttd" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Status</label>
                        <div class="col-9 col-form-label">
                            <div class="radio-inline">
                                <label class="radio radio-success">
                                    <input type="radio" name="status_ttd" id="status_ttd1" value="active">
                                    <span></span>Aktif
                                </label>
                                <label class="radio radio-danger">
                                    <input type="radio" name="status_ttd" id="status_ttd2" value="inactive">
                                    <span></span>Non Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <a class="btn btn-outline-primary font-weight-bolder btn-back-ttd">
                            <i class="fas fa-angle-double-left"></i> Kembali
                        </a>
                        <button type="reset"  class="btn btn-default">Reset <i class="flaticon2-reload"></i></button>
                        <button type="submit"  class="btn btn-primary btn-save-form-ttd">Simpan <i class="flaticon-paper-plane"></i></button>
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
        const url_json = "referensi/ttd/ajax-data";
        const role_id = '{{auth()->user()->role_id}}';
    </script>
        
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/module/referensi/ttd.js?random='.date('ymdHis')) }}" type="text/javascript"></script>

@endsection
{{-- Content --}}



