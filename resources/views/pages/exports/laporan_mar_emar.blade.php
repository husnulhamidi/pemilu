<table>
    <thead>
    <tr>
        <th width="40px" style="background-color: #00bfff">NO.</th>
        <th width="120px" style="background-color: #00bfff">No. INVOICE</th>
        <th width="100px" style="background-color: #00bfff">TGL. INVOICE</th>
        <th width="100px" style="background-color: #00bfff">TGL. BAYAR</th>
        <th width="150px" style="background-color: #00bfff">NAMA VENDOR</th>
        <th width="100px" style="background-color: #00bfff">NO. KONTRAK/PO/PK</th>
        <th width="150px" style="background-color: #00bfff">URAIAN PEKERJAAN</th>
        <th width="150px" style="background-color: #00bfff">KET. TAMBAHAN</th>
        <th width="100px" style="background-color: #00bfff">NILAI INVOICE</th>
        <th width="100px" style="background-color: #00bfff">PENALTI </th>
        <th width="120px" style="background-color: #00bfff">KATEGORI MAR </th>
        <th width="120px" style="background-color: #00bfff">KATERGORI BIAYA</th>
        <th width="100px" style="background-color: #00bfff">BIDANG </th>
        <th width="120px" style="background-color: #00bfff">NOMOR PRK </th>
        <th width="100px" style="background-color: #00bfff">UNIT </th>
        <th width="100px" style="background-color: #00bfff">NILAI AO </th>
        <th width="100px" style="background-color: #00bfff">NILAI AKO </th>
        <th width="100px" style="background-color: #00bfff">SALDO AKO </th>
        <th width="140px" style="background-color: #00bfff">GROUP REIMBURSE </th>
        <th width="140px" style="background-color: #00bfff">JENIS PENGAJUAN </th>
        <th width="140px" style="background-color: #00bfff">KETERANGAN / STATUS </th>
    </tr>
    </thead>
    <tbody>
    @php
        $i=0;
    @endphp
    @foreach($invoices as $invoice)
        @php
           $i++; 
           $status = "Waiting Payment";
           $status_color = "#FFA800";
           if($invoice->tahapan_id==16){
               $status = "Paid";
               $status_color = "#1BC5BD";
           }
           if((int) $invoice->reimburse_id>0){
               $reimburse = $invoice->uraian;
               $tgl_bayar = $invoice->tgl_bayar_reimburse;
               $jenisInv = "Reimburse";
           }else{
                $reimburse = "";
                $tgl_bayar = $invoice->tgl_bayar;
                $jenisInv = "Non Reimburse";
           }

           if($invoice->jenis_transaksi!=""){
                $jenisTrans = $invoice->jenis_transaksi;
           }else{
                $jenisTrans = $jenisInv;
           }
        @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $invoice->no_invoice }}</td>
            <td>{{ date('d-m-Y',strtotime($invoice->tgl_invoice)) }}</td>
            <td>{{ date('d-m-Y',strtotime($tgl_bayar)) }}</td>
            <td>{{ $invoice->nama_vendor }}</td>
            <td>{{ $invoice->no_kontrak }}</td>
            <td>{{ $invoice->uraian_pekerjaan }}</td>
            <td>{{ $invoice->ket_tambahan?$invoice->ket_tambahan:"" }}</td>
            <td>{{ $invoice->nilai_invoice_idr }}</td>
            <td>{{ $invoice->pinalty }}</td>
            <td>{{ $invoice->kategori_mar }}</td>
            <td>{{ $invoice->kategori_prk }}</td>
            <td>{{ $invoice->bidang }}</td>
            <td>{{ $invoice->no_prk }}</td>
            <td>{{ $invoice->unit }}</td>
            <td>{{ $invoice->anggaran_operasi }}</td>
            <td>{{ $invoice->ako }}</td>
            <td>{{ $invoice->prk_saldo_ako }}</td>
            <td>{{ $reimburse }}</td>
            <td>{{ $jenisTrans }}</td>
            <td style="color:{{$status_color}}">{{ $status }}</td>
            
        </tr>
    @endforeach
    </tbody>
</table>