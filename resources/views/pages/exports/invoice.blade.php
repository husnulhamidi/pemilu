<table>
    <thead>
    <tr>
        @if (in_array("tgl_masuk_dok", $ColumnShow))
        <th width="20" style="background-color: #00bfff">TGL MASUK DOK KE KEUANGAN</th>
        @endif
        @if (in_array("no_invoice", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NO INVOICE</th>
        @endif
        @if (in_array("tgl_invoice", $ColumnShow))
        <th width="15" style="background-color: #00bfff">TGL INVOICE</th>
        @endif
        @if (in_array("vendor", $ColumnShow))
        <th width="25" style="background-color: #00bfff">Nama Vendor</th>
        @endif
        @if (in_array("no_kontrak", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NO KONTRAK (SPK/PO/PK)</th>
        @endif
        @if (in_array("no_doc_sap", $ColumnShow))
        <th width="30" style="background-color: #00bfff">NO DOC SAP</th>
        @endif
        @if (in_array("uraian", $ColumnShow))
        <th width="30" style="background-color: #00bfff">URAIAN</th>
        @endif
        @if (in_array("bank", $ColumnShow))
        <th width="10" style="background-color: #00bfff">BANK</th>
        @endif
        @if (in_array("mata_uang", $ColumnShow))
        <th width="12" style="background-color: #00bfff">MATA UANG</th>
        @endif
        @if (in_array("nominal", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NOMINAL INV</th>
        @endif
        @if (in_array("kurs", $ColumnShow))
        <th width="15" style="background-color: #00bfff">KURS</th>
        @endif
        @if (in_array("nominal_idr", $ColumnShow))
        <th width="17" style="background-color: #00bfff">NOMINAL INV IDR</th>
        @endif
        @if (in_array("ppn", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PPN</th>
        @endif
        @if (in_array("pph21", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PPH 21</th>
        @endif
        @if (in_array("pph4_2", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PPH 4(2)</th>
        @endif
        @if (in_array("pph15", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PPH 15</th>
        @endif
        @if (in_array("pph22", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PPH 22</th>
        @endif
        @if (in_array("pph23", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PPH 23</th>
        @endif
        @if (in_array("pinalty", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PINALTY</th>
        @endif
        @if (in_array("netto", $ColumnShow))
        <th width="15" style="background-color: #00bfff">ROUNDING</th>
        @endif
        @if (in_array("netto", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NETTO</th>
        @endif
        @if (in_array("tgl_bayar", $ColumnShow))
        <th width="15" style="background-color: #00bfff">TANGGAL BAYAR</th>
        @endif
        @if (in_array("no_doc_bayar", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NO DOC BAYAR</th>
        @endif
        @if (in_array("no_prk", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NO PRK</th>
        @endif
       
        @if (in_array("jenis_invoice", $ColumnShow))
        <th width="15" style="background-color: #00bfff">JENIS INVOICE</th>
        @endif
        @if (in_array("kendala", $ColumnShow))
        <th width="30" style="background-color: #00bfff">KENDALA</th>
        @endif
        @if (in_array("status_payment", $ColumnShow))
        <th width="15" style="background-color: #00bfff">STATUS PAYMENT</th>
        @endif
        @if (in_array("arsip", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NO. ARSIP</th>
        @endif
        @if (in_array("sla", $ColumnShow))
        <th width="30" style="background-color: #00bfff">SLA</th>
        @endif
       
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $inv)
        @php
           if($inv->tahapan_id==16){
               $status_payment = "PAID";
           } 
           else if($inv->tahapan_id<16 AND $inv->is_cancel_payment=='1'){
                $status_payment = "Canceled";
           }
           else if($inv->tahapan_id<16 AND $inv->is_cancel_payment=='2'){
                $status_payment = "Pending/Confirm";
            }else{
                $status_payment = "Waiting Payment";
            }
            if($inv->reimburse_id!=""){
                $jenis_invoice = "REIMBURSE";
            }else{
                $jenis_invoice = "NON REIMBURSE";
            }
            $kendala = "";
            $sla = findDaysSLA($inv->id);
            $nama_bank="";$tgl_bayar="-";$no_cek="";$no_doc_bayar="";
            if(intval($inv->reimburse_id)>0){
                $nama_bank = @$inv->reimburse->bank->bank?$inv->reimburse->bank->bank:"";
                $tgl_bayar = @$inv->reimburse->tgl_bayar?date('d-m-Y',strtotime(@$inv->reimburse->tgl_bayar)):'-';
                $no_cek    = @$inv->reimburse->no_cek?$inv->reimburse->no_cek:"";
                $no_doc_bayar    = @$inv->reimburse->no_dokumen_bayar?$inv->reimburse->no_dokumen_bayar:"";
            }
        @endphp
        <tr>
            @if (in_array("tgl_masuk_dok", $ColumnShow))
            <td>{{ date('d-m-Y H:i:s',strtotime($inv->created_at)) }}</td>
            @endif
            @if (in_array("no_invoice", $ColumnShow))
            <td>{{ $inv->no_invoice }}</td>
            @endif
            @if (in_array("tgl_invoice", $ColumnShow))
            <td>{{ date('d-m-Y',strtotime($inv->tgl_invoice)) }}</td>
            @endif
            @if (in_array("vendor", $ColumnShow))
            <td>{{ $inv->nama_vendor }}</td>
            @endif
            @if (in_array("no_kontrak", $ColumnShow))
            <td>{{ $inv->no_kontrak }}</td>
            @endif
            @if (in_array("no_doc_sap", $ColumnShow))
            <td>{{ $inv->sap }}</td>
            @endif
            @if (in_array("uraian", $ColumnShow))
            <td>{{ $inv->uraian_pekerjaan }}</td>
            @endif
            @if (in_array("bank", $ColumnShow))
            <td>{{ $inv->bank?$inv->bank:$nama_bank }}</td>
            @endif
            @if (in_array("mata_uang", $ColumnShow))
            <td>{{ $inv->currency?$inv->currency:"" }}</td>
            @endif
            @if (in_array("nominal", $ColumnShow))
            <td>{{ $inv->nilai_invoice }}</td>
            @endif
            @if (in_array("kurs", $ColumnShow))
            <td>{{ $inv->kurs }}</td>
            @endif
            @if (in_array("nominal_idr", $ColumnShow))
            <td>{{ $inv->nilai_invoice_idr }}</td>
            @endif
            @if (in_array("ppn", $ColumnShow))
            <td>{{ $inv->nilai_ppn }}</td>
            @endif
            @if (in_array("pph21", $ColumnShow))
            <td>{{ $inv->pajak_id==2?$inv->nilai_pajak:'-' }}</td>
            @endif
            @if (in_array("pph4_2", $ColumnShow))
            <td>{{ $inv->pajak_id==3?$inv->nilai_pajak:'-' }}</td>
            @endif
            @if (in_array("pph15", $ColumnShow))
            <td>{{ $inv->pajak_id==4?$inv->nilai_pajak:'-' }}</td>
            @endif
            @if (in_array("pph22", $ColumnShow))
            <td>{{ $inv->pajak_id==5?$inv->nilai_pajak:'-' }}</td>
            @endif
            @if (in_array("pph23", $ColumnShow))
            <td>{{ $inv->pajak_id==6?$inv->nilai_pajak:'-' }}</td>
            @endif
            @if (in_array("pinalty", $ColumnShow))
            <td>{{ $inv->pinalty }}</td>
            @endif
            @if (in_array("netto", $ColumnShow))
            <td>{{ $inv->rounding?$inv->rounding:"-" }}</td>
            @endif
            @if (in_array("netto", $ColumnShow))
            <td>{{ $inv->netto }}</td>
            @endif
            @if (in_array("tgl_bayar", $ColumnShow))
            <td>{{ isset($inv->tgl_bayar)?date('d-m-Y',strtotime($inv->tgl_bayar)):$tgl_bayar }}</td>
            @endif
            @if (in_array("no_doc_bayar", $ColumnShow))
            <td>{{ isset($inv->no_dokumen_bayar)?$inv->no_dokumen_bayar:$no_doc_bayar }}</td>
            @endif
            @if (in_array("no_prk", $ColumnShow))
            <td>{{ $inv->no_prk }}</td>
            @endif
            @if (in_array("jenis_invoice", $ColumnShow))
            <td>{{ $jenis_invoice }}</td>
            @endif
            @if (in_array("kendala", $ColumnShow))
            <td>
                @if (!empty($inv->history_kendala))
                    @foreach ($inv->history_kendala as $key => $val )
                        @php
                        if($val->kendala!=""){
                            $kendala .= $val->kendala.'; '; 
                        } 
                        @endphp
                    @endforeach  
                    {{substr($kendala,0,-2)}}
                @endif
                
            </td>
            @endif
            @if (in_array("status_payment", $ColumnShow))
            <td>{{ $status_payment }}</td>
            @endif
            @if (in_array("arsip", $ColumnShow))
            <td>{{ $inv->no_arsip?$inv->no_arsip:'' }}</td>
            @endif
            @if (in_array("sla", $ColumnShow))
            <td>{{ $sla['sla']." (".$sla['date'].")"}}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>