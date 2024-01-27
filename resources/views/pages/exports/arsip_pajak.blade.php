<table>
    <thead>
    <tr>
        <th height="20px" colspan="7" align="center"><h1><b>REKAP ARSIP PAJAK</b></h1></th>
    </tr>
    <tr>
        <th height="10"></th>
    </tr>
    <tr>
        <th width="10" style="background-color: #00bfff">NO.</th>
        <th width="15" style="background-color: #00bfff">JENIS PAJAK</th>
        <th width="15" style="background-color: #00bfff">MASA PAJAK</th>
        <th width="15" style="background-color: #00bfff">NO. DOC SAP</th>
        <th width="15" style="background-color: #00bfff">TANGGAL</th>
        <th width="30" style="background-color: #00bfff">KETERANGAN</th>
        <th width="15" style="background-color: #00bfff">NAMA DOKUMEN</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i=0;
    @endphp
    @foreach($pajak as $pjk)
        @php
           $i++; 
        @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $pjk->jenis_pajak }}</td>
            <td>{{ $pjk->masa_pajak }}</td>
            <td>{{ $pjk->no_doc_sap }}</td>
            <td>{{ date('d-m-Y',strtotime($pjk->tgl_pajak)) }}</td>
            <td>{{ $pjk->uraian }}</td>
            <td>{{ $pjk->keterangan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>