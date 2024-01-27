{{-- Extends layout --}}
@extends('layout.default')

@section('content')
<div class="card card-custom">
 
    <div class="card-body">
        <form action="javascript:;" method="post" id="form-profile" enctype="multipart/form-data">
            <input type="hidden" name="UserID" id="UserID" value=""/>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">NIP <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input disabled name="nip" id="nip" type="text" class="form-control input-sm" value="{{$user->nip}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input disabled name="nama" id="nama" type="text" class="form-control input-sm" value="{{$user->name}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input disabled name="email" id="email" type="text" class="form-control input-sm" value="{{$user->email}}">
                   
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Password <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input name="passkey" id="passkey" type="text" autocomplete="off" class="form-control input-sm" value="{{$password}}">
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
                <label class="col-sm-3 col-form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input name="konfirmasi_password" id="konfirmasi_password" autocomplete="off" type="text" class="form-control input-sm" value="{{$password}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Role </label>
                <div class="col-sm-4">
                    {{$role->role}}
                </div>
            </div>
            <div class="text-right">
                <a class="btn btn-outline-primary font-weight-bolder btn-back-users">
                    <i class="fas fa-angle-double-left"></i> Kembali
                </a>
                
                <button type="reset"  class="btn btn-default">Reset <i class="flaticon2-reload"></i></button>
                <button type="submit" id="btn-update-profile" class="btn btn-primary btn-update-profile">Simpan <i class="flaticon-paper-plane"></i></button>
            </div>
        </form>

     
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
        const role_id = '{{auth()->user()->role_id}}';
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <script src="{{ asset('js/module/system/users.js') }}" type="text/javascript"></script>
    <script src='{{ asset('js/password-strength-check-profile.js') }}'></script>
@endsection
{{-- Content --}}