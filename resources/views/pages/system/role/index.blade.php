{{-- Extends layout --}}
@extends('layout.default')

@section('content')
    <div class="panel-grid-roles">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar Role
                    </h3>
                </div>
                <div class="card-toolbar">

                    @if ($accessMenu['add']=='true')
                    <!--begin::Button-->
                    <a class="btn btn-primary font-weight-bolder btn-create-role">
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
            <div class="card-body" >
                <div style="overflow-x: scroll">
                <!--begin: Datatable-->
                <table class="table table-bordered " id="tbl_roles">
                    <thead>
                        <tr>
                            <th >No.</th>
                            <th >Role</th>
                            <th width="220px" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-form-create-role" style="display: none">
        @include('pages/system/role/form_create_role')
    </div>
    

    <div class="panel-form-role" style="display: none">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Form Update Role 
                    </h3>
                </div>
                <div class="card-toolbar">
                    
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:;" method="post" id="form-roles" enctype="multipart/form-data">
                    <input type="hidden" name="RoleID" id="RoleID" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3">Role</label>
                        <div class="col-sm-9">
                            <b><span id="RoleLabel"></span></b>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Pengaturan Akses Menu</label>
                        <div class="col-sm-9">
                            <div class="panel-group-access"></div>
                        </div>
                    </div>

                    <div class="row" style="display:none;border-bottom:1px dashed #ccc;padding-bottom:5px">
                        <label class="col-sm-6"><b>Disposisi / Meneruskan ?</b></label>
                        <div class="col-sm-6">
                            <div class="radio-inline">
                                <label class="radio radio-primary ">
                                <input value="1" type="radio" name="disposisi" id="disposisi1" />
                                    <span></span>Ya</label>
                                <label class="radio radio-primary ">
                                <input value="0" type="radio" name="disposisi" id="disposisi0" />
                                    <span></span>Tidak 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;border-bottom:1px dashed #ccc;padding-bottom:5px">
                        <label class="col-sm-6"><b>Mengembalikan Dok. Ke bawahan/Staf Lain ?</b></label>
                        <div class="col-sm-6">
                            <div class="radio-inline">
                                <label class="radio radio-primary ">
                                <input value="1" type="radio" name="kembalikan_dok" id="kembalikan_dok1"/>
                                    <span></span>Ya</label>
                                <label class="radio radio-primary ">
                                <input value="0" type="radio" name="kembalikan_dok" id="kembalikan_dok0" />
                                    <span></span>Tidak 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;border-bottom:1px dashed #ccc;padding-bottom:5px">
                        <label class="col-sm-6"><b>Mengembalikan / Konfirmasi Dok. ke user ?</b></label>
                        <div class="col-sm-6">
                            <div class="radio-inline">
                                <label class="radio radio-primary ">
                                <input value="1" type="radio" name="konfirmasi_dok" id="konfirmasi_dok1"/>
                                    <span></span>Ya</label>
                                <label class="radio radio-primary ">
                                <input value="0" type="radio" name="konfirmasi_dok" id="konfirmasi_dok0"/> 
                                    <span></span>Tidak 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;border-bottom:1px dashed #ccc;padding-bottom:5px">
                        <label class="col-sm-6"><b>Edit Dok./ Data Verifikasi ?</b></label>
                        <div class="col-sm-6">
                            <div class="radio-inline">
                                <label class="radio radio-primary ">
                                <input value="1" type="radio" name="edit_dok" id="edit_dok1"/>
                                    <span></span>Ya</label>
                                <label class="radio radio-primary ">
                                <input value="0" type="radio" name="edit_dok"  id="edit_dok0"/>
                                    <span></span>Tidak 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;border-bottom:1px dashed #ccc;padding-bottom:5px">
                        <label class="col-sm-6"><b>Edit Teks pada dokumen Input ?</b></label>
                        <div class="col-sm-6">
                            <div class="radio-inline">
                                <label class="radio radio-primary ">
                                <input value="1" type="radio" name="edit_text" id="edit_text1"/>
                                    <span></span>Ya</label>
                                <label class="radio radio-primary ">
                                <input value="0" type="radio" name="edit_text" id="edit_text0" />
                                    <span></span>Tidak 
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <a class="btn btn-outline-primary font-weight-bolder btn-back-roles">
                            <i class="fas fa-angle-double-left"></i> Kembali
                        </a>
                        <button type="reset"  class="btn btn-default">Reset <i class="flaticon2-reload"></i></button>
                        <button type="submit"  class="btn btn-primary btn-save-form-roles">Simpan <i class="flaticon-paper-plane"></i></button>
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
        const url_json = "system/role/ajax-data";
        const url_generate_menu_access = "{{route('generate-menu-access')}}";
        const role_id = '{{auth()->user()->role_id}}';
    </script>
        
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/module/system/roles.js') }}" type="text/javascript"></script>

@endsection
{{-- Content --}}



