<div class="card card-custom">
    <div class="card-header text-white header-elements-inline">
        <div class="card-title">
            <h3 class="card-label"> Form Menu dan Akses
        </div>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="javascript:;" method="post" id="form_menu" enctype="multipart/form-data">
        <input type="hidden" name="MenuID" id="MenuID" value="">
            <div class="row">
                <div class="col-md-7">
                    
                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Menu Parent:</label>
                        <div class="col-lg-9">
                        <select class="form-control select2" name="MenuParentID" id="MenuParentID" style="width: 100%">
                            <option value="">...............?</option>
                            @foreach($parent as $key)    
                                <option value="{{$key->id}}">{{$key->title}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Nama Menu:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control input-sm" placeholder="" name="MenuName" id="MenuName" value="<?php echo @$detail['MenuName']; ?>">
                        </div>
                    </div>
            
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Module:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control input-sm" placeholder="" name="MenuModule" id="MenuModule" value="<?php echo @$detail['MenuModule']; ?>">
                        </div>
                    </div>
              
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Parent ?</label>
                        <div class="col-9 col-form-label">
                            <div class="radio-inline">
                                <label class="radio radio-success">
                                    <input type="radio" name="IsParent" id="IsParent1" value="1">
                                    <span></span>Ya
                                </label>
                                <label class="radio radio-danger">
                                    <input type="radio" name="IsParent" id="IsParent2" value="0">
                                    <span></span>Tidak
                                </label>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Urutan:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" placeholder="" name="MenuOrder" id="MenuOrder" value="<?php echo @$detail['MenuOrder']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Icon:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" placeholder="" name="MenuIcon" id="MenuIcon" value="<?php echo @$detail['MenuLogo']; ?>">
                        </div>
                    </div>
                        

                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-12">Pengaturan Akses Menu</label>
                        <div class="col-md-8 panel-menu-action">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <a class="btn btn-outline-primary font-weight-bolder btn-back-menu">
                    <i class="fas fa-angle-double-left"></i> Kembali
                </a>
                <button type="reset"  class="btn btn-default">Reset <i class="flaticon2-reload"></i></button>
                <button type="submit"  class="btn btn-primary btn-save-form-menu">Simpan <i class="flaticon-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>