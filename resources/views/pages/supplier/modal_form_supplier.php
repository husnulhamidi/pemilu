 <!-- Modal-->
 <div class="modal fade" id="AddSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-submit-supplier" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="SupplierID" id="SupplierID" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Supplier <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="nama_supplier" id="nama_supplier" class="form-control input-sm" placeholder=""  value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. Tlp </label>
                        <div class="col-sm-4">
                            <input type="text" name="telp" id="telp" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">alamat  </label>
                        <div class="col-lg-9">
                            <textarea name="alamat" id="alamat" type="text" class="form-control input-sm" value=""></textarea>
                        </div>
                    </div>
            
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. Rekening </label>
                        <div class="col-sm-9">
                            <input name="no_rekening" id="no_rekening" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Rekening </label>
                        <div class="col-sm-9">
                            <input name="nama_rekening" id="nama_rekening" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Bank </label>
                        <div class="col-sm-9">
                            <input name="nama_bank" id="nama_bank" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-submit-supplier" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i> </button>
                </div>
            </form>
        </div>
    </div>
</div>