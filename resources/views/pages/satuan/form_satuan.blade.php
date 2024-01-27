<!-- Modal-->
<div class="modal fade" id="ModalSatuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-submit-satuan" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="satuan_id" id="satuan_id" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Satuan <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="nama_satuan" id="nama_satuan" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn_submit_satuan" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
