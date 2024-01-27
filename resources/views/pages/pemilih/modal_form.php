 <!-- Modal-->
 <div class="modal fade" id="AddPemilih" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Pemilih</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-submit-pemilih" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="pemilih_id" id="pemilih_id" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="nama" id="nama" class="form-control input-sm" placeholder=""  value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIK </label>
                        <div class="col-sm-4">
                            <input type="text" name="nik" id="nik" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. HP / WA </label>
                        <div class="col-sm-4">
                            <input type="text" name="telp" id="telp" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Umur</label>
                        <div class="col-sm-4">
                            <input type="text" name="umur" id="umur" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status  </label>
                        <div class="col-lg-9">
                            <select name="status" id="status" class="form-control form-control input-sm select2" style="width:100%">
                                <option value="">-- Pilih --</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Lajang">Lajang</option>
                                <option value="Janda">Janda</option>
                                <option value="Duda">Duda</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">alamat  </label>
                        <div class="col-lg-9">
                            <textarea name="alamat" id="alamat" type="text" class="form-control input-sm" value=""></textarea>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-submit-pemilih" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i> </button>
                </div>
            </form>
        </div>
    </div>
</div>