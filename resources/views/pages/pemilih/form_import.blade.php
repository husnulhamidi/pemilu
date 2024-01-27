 <!-- Modal-->
 <div class="modal fade" id="AddImportExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Pemilih</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-import-pemilih" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <label  class="col-sm-3 col-form-label" >Upload Excel Pemilih</label>
                        <div class="col-sm-9" >
                            <input type="file" required accept=".csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  name="dokumen_pemilih" id="dokumen_pemilih" value="" placeholder="..." class="form-control input-sm"  >
                            <span class="form-text text-muted"><code>Hanya format excel (xlsx)</code></span>
                            <br>
                            <a href="../template/pemilih.xlsx"><div class="btn btn-outline-primary btn-sm">Download Template</div></a>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-submit-import" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i> </button>
                </div>
            </form>
        </div>
    </div>
</div>