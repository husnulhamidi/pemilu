<table>
    <thead>
        <tr>
            <th height="15px" colspan="18"></th>
        </tr>
        <tr>
            <th colspan="18"><b>{{strtoupper($reimburse)}}</b></th>
        </tr>
        <tr>
            <th height="20px" colspan="18"></th>
        </tr>
    <tr>
        <th width="20" style="background-color: #00bfff">TGL MASUK DOK KE KEUANGAN</th>
        <th width="15" style="background-color: #00bfff">NO INVOICE</th>
        <th width="15" style="background-color: #00bfff">TGL INVOICE</th>
        <th width="15" style="background-color: #00bfff">NAMA VENDOR</th>
        <th width="15" style="background-color: #00bfff">NO KONTRAK (SPK/PO/PK)</th>
        <th width="15" style="background-color: #00bfff">NO DOC SAP</th>
        <th width="30" style="background-color: #00bfff">URAIAN</th>
        <th width="12" style="background-color: #00bfff">MATA UANG</th>
        <th width="15" style="background-color: #00bfff">NOMINAL INV</th>
        <th width="15" style="background-color: #00bfff">PPN</th>
        <th width="15" style="background-color: #00bfff">PPH 21</th>
        <th width="15" style="background-color: #00bfff">PPH 4(2)</th>
        <th width="15" style="background-color: #00bfff">PPH 15</th>
        <th width="15" style="background-color: #00bfff">PPH 22</th>
        <th width="15" style="background-color: #00bfff">PPH 23</th>
        <th width="15" style="background-color: #00bfff">PINALTY</th>
        <th width="15" style="background-color: #00bfff">NETTO</th>
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
        @endphp
        <tr>
            <td>{{ date('d-m-Y H:i:s',strtotime($inv->created_at)) }}</td>
            <td>{{ $inv->no_invoice }}</td>
            <td>{{ date('d-m-Y',strtotime($inv->tgl_invoice)) }}</td>
            <td>{{ $inv->nama_vendor }}</td>
            <td>{{ $inv->no_kontrak }}</td>
            <td>{{ $inv->sap }}</td>
            <td>{{ $inv->uraian_pekerjaan }}</td>
            <td>{{ $inv->currency?$inv->currency:"" }}</td>
            <td>{{ $inv->nilai_invoice }}</td>
            <td>{{ $inv->nilai_ppn }}</td>
            <td>{{ $inv->pajak_id==2?$inv->nilai_pajak:'-' }}</td>
            <td>{{ $inv->pajak_id==3?$inv->nilai_pajak:'-' }}</td>
            <td>{{ $inv->pajak_id==4?$inv->nilai_pajak:'-' }}</td>
            <td>{{ $inv->pajak_id==5?$inv->nilai_pajak:'-' }}</td>
            <td>{{ $inv->pajak_id==6?$inv->nilai_pajak:'-' }}</td>

            <td>{{ $inv->pinalty }}</td>
            <td>{{ $inv->netto }}</td>
        </tr>
    @endforeach
    </tbody>
</table>