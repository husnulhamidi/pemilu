
    <table  style="font-size:10">
        <tr>
            <td width="250px" colspan="2">NO. VENDOR</td>
            <td align="left" colspan="2">{{$inv->sapid?$inv->sapid:''}}</td>
        </tr>
        <tr>
            <td width="250px" colspan="2">NAMA VENDOR</td>
            <td align="left" colspan="2">{{$inv->nama_vendor}}</td>
        </tr>
        <tr>
            <td colspan="2">KONTRAK (SPK/PO/PK)</td>
            <td align="left" colspan="2">{{$inv->no_kontrak}}</td>
        </tr>
        <tr>
            <td colspan="2" >URAIAN PEKERJAAN</td>
            <td align="left" colspan="2">{{$inv->uraian_pekerjaan}}</td>
        </tr>
        <tr>
            <td colspan="2">PERIODE</td>
            <td align="left" colspan="2">{{$inv->periode}}</td>
        </tr>
        <tr>
            <td colspan="2">NO. DOC SAP</td>
            <td align="left" colspan="2">{{$inv->sap}}</td>
        </tr>
    </table>
    <br>
    <table border="1">
        <thead>
        <tr>
            <th width='5' align="center">NO</th>
            <th width='28' align="center">URAIAN</th>
            <th width='25' align="center">ADA / TIDAK</th>
            <th width='25' align="center">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
            @php
                $i=0;
                $tgl_verifikasi = "..............................";
            @endphp
            @foreach($cheklistKelengkapan as $checklist => $check )
                @php
                    $i++;    
                    if($check->is_check==1){
                        $checked = "☑";
                        $checkbox = "checkbox.png";
                        $tgl_verifikasi = date('d/m/Y',strtotime($check->created_at));
                    }else{
                        $checked = "☐";
                        $checkbox = "unchecked.png";
                    }
                @endphp
                <tr>
                    <td align="center">{{$i}}</td>
                    <td>{{$check->uraian}}</td>
                    <td align="center">
                        {{$checked}}
                    </td>
                    <td>{{$check->keterangan}}</td>
                
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <table >
        <tr style="">
            <td  colspan="2"><b>Tagihan</b></td>
            <td  >: <b> {{$inv->currency}}</b></td>
            <td  align="right" ><b>{{$inv->nilai_invoice}}</b></td>
        </tr>
        <tr>
            <td colspan="2">DPP</td>
            <td  >: {{$inv->currency}}</td>
            <td  align="right" >{{$inv->dpp}}</td>
        </tr>
        <tr>
            <td colspan="2">PPN {{$inv->tarif_ppn}}%</td>
            <td  >: {{$inv->currency}}</td>
            <td align="right" >{{$inv->nilai_ppn}}</td>
        </tr>
        <tr> 
            <td colspan="2">{{$inv->pph?$inv->pph:"PPH"}} {{$inv->tarif?$inv->tarif."%":''}}</td>
            <td  >: {{$inv->currency}}</td>
            <td  align="right" >{{$inv->nilai_pajak}}</td>
        </tr>
        <tr> 
            <td colspan="2">Penalty</td>
            <td  >: {{$inv->currency}}</td>
            <td  align="right" >{{$inv->pinalty}}</td>
        </tr>
        <tr> 
            <td colspan="2"><b>Nilai yang dibayarkan ke Vendor</b></td>
            <td  >: <b> {{$inv->currency}}</b></td>
            <td  align="right" ><b>{{$inv->netto}}</b></td>
        </tr>
    </table> 

    <table>
        <tr>
            <td colspan="4">Note : &nbsp;{{$inv->note}}</td>
        </tr>
    </table>

    <div style="border: 1px solid #ccc">
    <table>
        <tr>
            <td colspan="2">Nama Bank</td><td colspan="2" align="left">{{$inv->nama_bank}}</td>
        </tr>
        <tr>
            <td colspan="2">Nomor Rekening</td><td colspan="2" align="left">{{$inv->no_rekening}}</td>
        </tr>
        <tr>
            <td  colspan="2">Nama Rekening</td><td colspan="2" align="left">{{$inv->nama_rekening}}</td>
        </tr>
    </table>
    </div>

    <table  style="font-size:11px">
        <tr>
            <td ></td>
            <td ></td>
            <td  align="center"><b>Mengetahui,</b></td>
            <td  align="center"><b>Menyetujui,</b></td>
        </tr>
        <tr>
            <td ></td>
            <td align="center">Verifikator</td>
            <td align="center">AMN KEU</td>
            <td align="center">MSB KEU dan AKT</td>
        </tr>
        <tr>
            <td height="40px"></td>
            <td ></td>
            <td ></td>
        </tr>
        <tr>
            <td ></td>
            <td align="center"><i>{{$inv->nama_verifikator}}</i></td>
            <td align="center"><i>AHMAD APRI S.</i></td>
            <td align="center"><i>ANDIANA WP</i></td>
        </tr>
        <tr>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
        </tr>
        <tr>
            <td ></td>
            <td ><i>Tgl. Verifikasi : {{$tgl_verifikasi}}</i></td>
            <td ><i>Tgl. Verifikasi : ..............................</i></td>
            <td ><i>Tgl. Verifikasi : ..............................</i></td>
        </tr>
    </table>


