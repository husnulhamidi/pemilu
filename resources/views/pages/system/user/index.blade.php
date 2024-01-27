{{-- Extends layout --}}
<link rel='stylesheet' href='{{ asset('css/custom.css') }}'>
@extends('layout.default')

@section('content')
    <div class="panel-grid-users">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Daftar User
                    </h3>
                </div>
                <div class="card-toolbar">
                   
                    @if ($accessMenu['add']=='true')
                    <!--begin::Button-->
                    <a class="btn btn-primary font-weight-bolder btn-add-user">
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
                <table class="table table-bordered " id="tbl_users">
                    <thead>
                        <tr>
                            <th >No.</th>
                            <th >NIP</th>
                            <th >Nama</th>
                            <th >Email</th>
                            <th >Role</th>
                            <th >Status Akun</th>
                            <th width="80px" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="panel-form-users" style="display: none">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Form User
                    </h3>
                </div>
                <div class="card-toolbar">
                    
                    <!--begin::Button-->
                   
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:;" method="post" id="form-users" enctype="multipart/form-data">
                    <input type="hidden" name="UserID" id="UserID" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIP <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="nip" id="nip" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="nama" id="nama" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="email" id="email" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" >Password <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input id="password" name="password" type="password" placeholder="" class="form-control input-sm" data-placement="bottom" data-toggle="popover" data-container="body" type="button" data-html="true" required :value="old('password')">
                            <div id="popover-password">
                                {{-- <p>Password Strength: <span id="result"> </span></p>
                                <div class="progress">
                                    <div id="password-strength" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                    </div>
                                </div> --}}
                                <ul class="list-unstyled">
                                    <li class=""><span class="low-upper-case"><i class="fa fa-file-text" aria-hidden="true"></i></span>&nbsp; 1
                                    lowercase &amp; 1 uppercase</li>
                                    <li class=""><span class="one-number"><i class="fa fa-file-text" aria-hidden="true"></i></span> &nbsp;1
                                    number (0-9)</li>
                                    <li class=""><span class="one-special-char"><i class="fa fa-file-text" aria-hidden="true"></i></span>
                                    &nbsp;1
                                    Special Character (!@#$%^&*).</li>
                                    <li class=""><span class="eight-character"><i class="fa fa-file-text" aria-hidden="true"></i></span>&nbsp;
                                    Atleast
                                    8 Character</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label" for="passwordinput">Password Confirmation <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input id="confirm-password" name="password_confirmation" type="password" placeholder="" class="form-control input-md" required :value="old('password_confirmation')">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Role <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select name="role_id" id="role_id" class="form-control input-sm select2" style="width:100%">
                                <option value="">Pilih Role ....?</option>
                                @foreach($role as $key)
    
                                <option value="{{$key->id}}">{{$key->role}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-outline-primary font-weight-bolder btn-back-users">
                            <i class="fas fa-angle-double-left"></i> Kembali
                        </a>
                        
                        <button type="reset"  class="btn btn-default">Reset <i class="flaticon2-reload"></i></button>
                        <button type="submit" id="btn-save-form-user" class="btn btn-primary btn-save-form-user">Simpan <i class="flaticon-paper-plane"></i></button>
                    </div>
                </form>
    
             
            </div>
        </div>
    </div>


    <div class="panel-form-update-users" style="display: none">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Form Update User
                    </h3>
                </div>
                <div class="card-toolbar">
                    
                    <!--begin::Button-->
                   
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:;" method="post" id="form-update-users" enctype="multipart/form-data">
                    <input type="hidden" name="UserID_up" id="UserID_up" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIP <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="nip_up" id="nip_up" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="nama_up" id="nama_up" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="email_up" id="email_up" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="password_up" id="password_up" type="text" class="form-control input-sm" value="">
                            <div id="popover-password">
                                <ul class="list-unstyled">
                                    <li class=""><span class="low-upper-case"><i class="fa fa-file-text" aria-hidden="true"></i></span>&nbsp; 1
                                    lowercase &amp; 1 uppercase</li>
                                    <li class=""><span class="one-number"><i class="fa fa-file-text" aria-hidden="true"></i></span> &nbsp;1
                                    number (0-9)</li>
                                    <li class=""><span class="one-special-char"><i class="fa fa-file-text" aria-hidden="true"></i></span>
                                    &nbsp;1
                                    Special Character (!@#$%^&*).</li>
                                    <li class=""><span class="eight-character"><i class="fa fa-file-text" aria-hidden="true"></i></span>&nbsp;
                                    Atleast
                                    8 Character</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Role <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select name="role_id_up" id="role_id_up" class="form-control input-sm select2" style="width:100%">
                                <option value="">Pilih Role ....?</option>
                                @foreach($role as $key)
    
                                <option value="{{$key->id}}">{{$key->role}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row boxstatus" >
                        <label class="col-sm-3 col-form-label">Status Akun <span class="text-danger">*</span></label>
                        <div class="col-sm-4 radio-inline">
                            
                                <label class="radio radio-primary radio_status radio_statusYes">
                                <input value="active" type="radio" name="is_status"  id="is_status1"/>
                                    <span></span>Active</label>
                                <label class="radio radio-primary radio_status radio_statusNo">
                                <input value="inactive" type="radio" name="is_status"  id="is_status0" />
                                    <span></span>Inactive
                                </label>
                            
                        </div>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-outline-primary font-weight-bolder btn-back-users">
                            <i class="fas fa-angle-double-left"></i> Kembali
                        </a>
                        
                        <button type="reset"  class="btn btn-default">Reset <i class="flaticon2-reload"></i></button>
                        <button type="submit" id="btn-update-form-user" class="btn btn-primary btn-update-form-user">Simpan <i class="flaticon-paper-plane"></i></button>
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
        const url_json = "system/users/ajax-data";
        const role_id = '{{auth()->user()->role_id}}';
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src='{{ asset('js/password-strength-check.js') }}'></script>
    <script src="{{ asset('js/module/system/users.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugin/PasswordStrength.min.js?random='.date('ymdHis')) }}" defer></script>
@endsection
{{-- Content --}}



