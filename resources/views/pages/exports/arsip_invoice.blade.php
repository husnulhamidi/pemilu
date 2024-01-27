<table>
    <thead>
    <tr>
        <th height="20px" colspan="7" align="center"><h1><b>REKAP ARSIP INVOICE</b></h1></th>
    </tr>
    <tr>
        <th height="10"></th>
    </tr>
    <tr>
        <th width="10" style="background-color: #00bfff">NO.</th>
        <th width="15" style="background-color: #00bfff">NO. INVOICE</th>
        <th width="15" style="background-color: #00bfff">TGL. INVOICE</th>
        <th width="15" style="background-color: #00bfff">NO. KONTRAK</th>
        <th width="40" style="background-color: #00bfff">URAIAN PEKERJAAN</th>
        <th width="30" style="background-color: #00bfff">VENDOR</th>
        <th width="20" style="background-color: #00bfff">NAMA DOKUMEN</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i=0;
    @endphp
    @foreach($invoices as $invoice)
        @php
           $i++; 
        @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $invoice->no_invoice }}</td>
            <td>{{ date('d-m-Y',strtotime($invoice->tgl_invoice)) }}</td>
            <td>{{ $invoice->no_kontrak }}</td>
            <td>{{ $invoice->uraian_pekerjaan }}</td>
            <td>{{ $invoice->nama_vendor }}</td>
            <td>{{ $invoice->keterangan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>