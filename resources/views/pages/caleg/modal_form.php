 <!-- Modal-->
 <div class="modal fade" id="AddCaleg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Caleg</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-caleg" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="caleg_id" id="caleg_id" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. Urut </label>
                        <div class="col-sm-4">
                            <input type="number" name="no_urut" id="no_urut" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="nama" id="nama" class="form-control input-sm" placeholder=""  value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Partai  </label>
                        <div class="col-lg-9">
                            <select name="partai" id="partai" class="form-control form-control input-sm select2" style="width:100%">
                                <option value="">-- Pilih --</option>
                                <option value="Partai Persatuan Pembangunan (PPP)">Partai Persatuan Pembangunan (PPP)</option>
                                <option value="Partai Kebangkitan Bangsa (PKB)">Partai Kebangkitan Bangsa (PKB)</option>
                                <option value="Partai Gerakan Indonesia Raya (Gerindra)">Partai Gerakan Indonesia Raya (Gerindra)</option>
                                <option value="Partai Demokrasi Indonesia Perjuangan (PDI Perjuangan)">Partai Demokrasi Indonesia Perjuangan (PDI Perjuangan)</option>
                                <option value="Partai Golongan Karya (Golkar)">Partai Golongan Karya (Golkar)</option>
                                <option value="Partai NasDem">Partai NasDem</option>
                                <option value="Partai Buruh">Partai Buruh</option>
                                <option value="Partai Gelombang Rakyat Indonesia (Gelora)">Partai Gelombang Rakyat Indonesia (Gelora)</option>
                                <option value="Partai Keadilan Sejahtera (PKS)">Partai Keadilan Sejahtera (PKS)</option>
                                <option value="Partai Kebangkitan Nusantara (PKN)">Partai Kebangkitan Nusantara (PKN)</option>
                                <option value="Partai Hati Nurani Rakyat (Hanura)">Partai Hati Nurani Rakyat (Hanura)</option>
                                <option value="Partai Garda Perubahan Indonesia (Garuda)">Partai Garda Perubahan Indonesia (Garuda)</option>
                                <option value="Partai Amanat Nasional (PAN)">Partai Amanat Nasional (PAN)</option>
                                <option value="Partai Bulan Bintang (PBB)">Partai Bulan Bintang (PBB)</option>
                                <option value="Partai Demokrat">Partai Demokrat</option>
                                <option value="Partai Solidaritas Indonesia (PSI)">Partai Solidaritas Indonesia (PSI)</option>
                                <option value="Partai Persatuan Indonesia (Perindo)">Partai Persatuan Indonesia (Perindo)</option>
                                <option value="Partai UMMAT">Partai UMMAT</option>
                               
                            </select>
                        </div>
                    </div>
                   
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-submit-caleg" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i> </button>
                </div>
            </form>
        </div>
    </div>
</div>