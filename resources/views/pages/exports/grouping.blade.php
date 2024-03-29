<table>
    <thead>
    <tr>
        @if (in_array("deskripsi", $ColumnShow))
        <th width="30" style="background-color: #00bfff">DESKRIPSI</th>
        @endif
        
        @if (in_array("tgl_bayar", $ColumnShow))
        <th width="15" style="background-color: #00bfff">TANGGAL BAYAR</th>
        @endif
        @if (in_array("cek", $ColumnShow))
        <th width="12" style="background-color: #00bfff">CEK</th>
        @endif
        @if (in_array("bank", $ColumnShow))
        <th width="10" style="background-color: #00bfff">BANK</th>
        @endif

        @if (in_array("mata_uang", $ColumnShow))
        <th width="12" style="background-color: #00bfff">MATA UANG</th>
        @endif
        @if (in_array("nilai", $ColumnShow))
        <th width="15" style="background-color: #00bfff">SALDO AWAL</th>
        @endif
        @if (in_array("nilai", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NILAI</th>
        @endif
        @if (in_array("nilai", $ColumnShow))
        <th width="15" style="background-color: #00bfff">SALDO AKHIR</th>
        @endif
        @if (in_array("nilai", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PARAF AMN KEU</th>
        @endif
        @if (in_array("nilai", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PARAF MSB KEU DAN AKT</th>
        @endif
        @if (in_array("nilai", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PARAF SRM KKU</th>
        @endif
       
    </tr>
    </thead>
    
    @foreach($grouping as $invgr)
        <tbody>
        <tr>
            @if (in_array("deskripsi", $ColumnShow))
            <td>{{ $invgr->keterangan }}</td>
            @endif
            @if (in_array("tgl_bayar", $ColumnShow))
            <td>{{ isset($invgr->tgl_bayar)?date('d-m-Y',strtotime($invgr->tgl_bayar)):'-' }}</td>
            @endif
           
            @if (in_array("cek", $ColumnShow))
            <td>{{ $invgr->no_cek }}</td>
            @endif
            @if (in_array("bank", $ColumnShow))
            <td>{{ $invgr->bank->bank?$invgr->bank->bank:"" }}</td>
            @endif
            @if (in_array("mata_uang", $ColumnShow))
            <td>{{ $invgr->bank->ref_currencies->currency?$invgr->bank->ref_currencies->currency:"" }}</td>
            @endif
           
            @if (in_array("nilai", $ColumnShow))
            <td>{{ $invgr->saldo_awal }}</td>
            @endif
            @if (in_array("nilai", $ColumnShow))
            <td>{{ $invgr->total_nilai }}</td>
            @endif
            @if (in_array("nilai", $ColumnShow))
            <td>{{ $invgr->saldo_akhir }}
            </td>
            @endif
           
        </tr>
        </tbody>
        @if (count($ColumnShowDetail)>1)    
            <thead>
                <tr>
                    <th height="15px" colspan="10"></th>
                </tr>
                <tr>
                    <th ></th>
                    @if (in_array("tgl_masuk_doc", $ColumnShowDetail))
                    <th width="20" style="background-color: #dcdcdc">TGL MASUK DOK KE KEUANGAN</th>
                    @endif
                    @if (in_array("no_invoice", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">NO INVOICE</th>
                    @endif
                    @if (in_array("tgl_invoice", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">TGL INVOICE</th>
                    @endif
                    @if (in_array("vendor", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">NAMA VENDOR</th>
                    @endif
                    @if (in_array("no_kontrak", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">NO KONTRAK (SPK/PO/PK)</th>
                    @endif
                    @if (in_array("no_doc_sap", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">NO DOC SAP</th>
                    @endif
                    @if (in_array("uraian", $ColumnShowDetail))
                    <th width="30" style="background-color: #dcdcdc">URAIAN</th>
                    @endif
                    @if (in_array("nominal_inv", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">NOMINAL INV</th>
                    @endif
                    @if (in_array("ppn", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">PPN</th>
                    @endif
                    @if (in_array("pph21", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">PPH 21</th>
                    @endif
                    @if (in_array("pph4_2", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">PPH 4(2)</th>
                    @endif
                    @if (in_array("pph15", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">PPH 15</th>
                    @endif
                    @if (in_array("pph22", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">PPH 22</th>
                    @endif
                    @if (in_array("pph23", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">PPH 23</th>
                    @endif
                    @if (in_array("pinalti", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">PINALTY</th>
                    @endif
                    @if (in_array("pinalti", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">Rounding</th>
                    @endif
                    @if (in_array("netto", $ColumnShowDetail))
                    <th width="15" style="background-color: #dcdcdc">NETTO</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($invgr->invoice as $inv)
                <tr>
                    <td></td>
                    @if (in_array("tgl_masuk_doc", $ColumnShowDetail))
                    <td>{{ $inv->created_at }}</td>
                    @endif
                    @if (in_array("no_invoice", $ColumnShowDetail))
                    <td>{{ $inv->no_invoice }}</td>
                    @endif
                    @if (in_array("tgl_invoice", $ColumnShowDetail))
                    <td>{{ date('d-m-Y',strtotime($inv->tgl_invoice)) }}</td>
                    @endif
                    @if (in_array("vendor", $ColumnShowDetail))
                    <td>{{ $inv->nama_vendor }}</td>
                    @endif
                    @if (in_array("no_kontrak", $ColumnShowDetail))
                    <td>{{ $inv->no_kontrak }}</td>
                    @endif
                    @if (in_array("no_doc_sap", $ColumnShowDetail))
                    <td>{{ $inv->sap }}</td>
                    @endif
                    @if (in_array("uraian", $ColumnShowDetail))
                    <td>{{ $inv->uraian_pekerjaan }}</td>
                    @endif
                    @if (in_array("nominal_inv", $ColumnShowDetail))
                    <td>{{ $inv->nilai_invoice }}</td>
                    @endif
                    @if (in_array("ppn", $ColumnShowDetail))
                    <td>{{ $inv->nilai_ppn }}</td>
                    @endif
                    @if (in_array("pph21", $ColumnShowDetail))
                    <td>{{ $inv->pajak_id==2?$inv->nilai_pajak:'-' }}</td>
                    @endif
                    @if (in_array("pph4_2", $ColumnShowDetail))
                    <td>{{ $inv->pajak_id==3?$inv->nilai_pajak:'-' }}</td>
                    @endif
                    @if (in_array("pph15", $ColumnShowDetail))
                    <td>{{ $inv->pajak_id==4?$inv->nilai_pajak:'-' }}</td>
                    @endif
                    @if (in_array("pph22", $ColumnShowDetail))
                    <td>{{ $inv->pajak_id==5?$inv->nilai_pajak:'-' }}</td>
                    @endif
                    @if (in_array("pph23", $ColumnShowDetail))
                    <td>{{ $inv->pajak_id==6?$inv->nilai_pajak:'-' }}</td>
                    @endif
                    @if (in_array("pinalti", $ColumnShowDetail))
                    <td>{{ $inv->pinalty }}</td>
                    @endif
                    @if (in_array("pinalti", $ColumnShowDetail))
                    <td>{{ $inv->rounding }}</td>
                    @endif
                    @if (in_array("netto", $ColumnShowDetail))
                    <td>{{ $inv->netto }}</td>
                    @endif
                </tr>
            @endforeach
            <tr>
                <th height="15px" colspan="10"></th>
            </tr>
            </tbody>
            @endif
    @endforeach
    
</table>