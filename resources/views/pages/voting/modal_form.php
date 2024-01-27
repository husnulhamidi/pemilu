 <!-- Modal-->
 <div class="modal fade" id="AddVoting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Perolehan Suara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-voting" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="voting_id" id="voting_id" value=""/>
                  
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kecamatan <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select name="kecamatan" id="kecamatan" class="form-control form-control input-sm select2" style="width:100%">
                                <option value="">-- Pilih --</option>
                                <?php 
                                    foreach ($kecamatan as $key => $value) {
                                ?>
                                    <option value="<?php echo $value->SubDistrictID;?>"><?php echo $value->SubDistrictName;?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Desa  <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select name="desa" id="desa" class="form-control form-control input-sm select2" style="width:100%">
                                <option value="">-- Pilih --</option>
                               
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Caleg  <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select name="caleg_id" id="caleg_id" class="form-control form-control input-sm select2" style="width:100%">
                                <option value="">-- Pilih --</option>
                                <?php 
                                    foreach ($caleg as $key => $value) {
                                ?>
                                    <option value="<?php echo $value->id;?>"><?php echo $value->nama;?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No TPS <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="number" name="no_tps" id="no_tps" class="form-control input-sm" placeholder=""  value="">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Perolehan Suara <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="number" name="suara" id="suara" class="form-control input-sm" placeholder=""  value="">
                        </div>
                    </div>
                    
                   
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-submit-voting" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i> </button>
                </div>
            </form>
        </div>
    </div>
</div>