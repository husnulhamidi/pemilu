<table>
    <thead>
    <tr>
      @if (in_array("jenis_pajak", $ColumnShow))
        <th width="15" style="background-color: #00bfff">JENIS PAJAK</th>
      @endif
      @if (in_array("masa_pajak", $ColumnShow))
        <th width="15" style="background-color: #00bfff">MASA PAJAK</th>
      @endif
      @if (in_array("no_doc_sap", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NO. DOC SAP</th>
      @endif
      @if (in_array("nilai_pajak", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NILAI PAJAK</th>
      @endif
      @if (in_array("tgl_pajak", $ColumnShow))
        <th width="15" style="background-color: #00bfff">TANGGAL</th>
      @endif
      @if (in_array("keterangan", $ColumnShow))
        <th width="30" style="background-color: #00bfff">KETERANGAN</th>
      @endif
      @if (in_array("no_cek", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NO. CEK / BG</th>
      @endif
      @if (in_array("no_doc_bayar", $ColumnShow))
        <th width="15" style="background-color: #00bfff">NO. DOC BAYAR</th>
      @endif
      @if (in_array("tgl_bayar", $ColumnShow))
        <th width="15" style="background-color: #00bfff">TANGGAL BAYAR</th>
      @endif
      @if (in_array("posisi_doc", $ColumnShow))
        <th width="20" style="background-color: #00bfff">POSISI DOC</th>
      @endif
      @if (in_array("status_doc", $ColumnShow))
        <th width="50" style="background-color: #00bfff">DIKEMBALIKAN/KONFIRMASI/PENDING</th>
      @endif
      @if (in_array("detail", $ColumnShow))
        <th width="15" style="background-color: #00bfff">PPh 21</th>
        <th width="15" style="background-color: #00bfff">PPh 4(2)</th>
        <th width="15" style="background-color: #00bfff">PPh 15</th>
        <th width="15" style="background-color: #00bfff">PPh 22</th>
        <th width="15" style="background-color: #00bfff">PPh 23</th>
      @endif
      
    </tr>
    </thead>
    <tbody>
    @foreach($pajak as $pjk)
        @php
           IF($pjk->is_verifikasi=='0'){
             $pending="Pending";
           }else{
             $pending="";
           }
          $PPh21="";
          $PPh4_2="";
          $PPh15="";
          $PPh22="";
          $PPh23="";
          if (in_array("detail", $ColumnShow)){
           foreach ($pjk->detail as $key => $val) {
              if($val->jenis_pajak_id==2){
                 $PPh21 = $val->nominal;
              }
              if($val->jenis_pajak_id==3){
                 $PPh4_2 = $val->nominal;
              }
              if($val->jenis_pajak_id==4){
                 $PPh15 = $val->nominal;
              }
              if($val->jenis_pajak_id==5){
                 $PPh22 = $val->nominal;
              }
              if($val->jenis_pajak_id==6){
                 $PPh23 = $val->nominal;
              }
           }
          }
        @endphp
        <tr>
          @if (in_array("jenis_pajak", $ColumnShow))
            <td>{{ $pjk->jenis_pajak }}</td>
          @endif
          @if (in_array("masa_pajak", $ColumnShow))
            <td>{{ $pjk->masa_pajak }}</td>
          @endif
          @if (in_array("no_doc_sap", $ColumnShow))
            <td>{{ $pjk->no_doc_sap }}</td>
          @endif
          @if (in_array("nilai_pajak", $ColumnShow))
            <td>{{ $pjk->nilai_pajak }}</td>
          @endif
          @if (in_array("tgl_pajak", $ColumnShow))
            <td>{{ date('d-m-Y',strtotime($pjk->tgl_pajak)) }}</td>
          @endif
          @if (in_array("keterangan", $ColumnShow))
            <td>{{ $pjk->keterangan }}</td>
          @endif
          @if (in_array("no_cek", $ColumnShow))
            <td>{{ $pjk->no_cek?$pjk->no_cek:'-' }}</td>
          @endif
          @if (in_array("no_doc_bayar", $ColumnShow))
            <td>{{ $pjk->no_dokumen_bayar?$pjk->no_dokumen_bayar:'-' }}</td>
          @endif
          @if (in_array("tgl_bayar", $ColumnShow))
            <td>{{ $pjk->tgl_bayar?date('d-m-Y',strtotime($pjk->tgl_bayar)):'' }}</td>
          @endif
          @if (in_array("posisi_doc", $ColumnShow))
            <td>{{ $pjk->tahapan }}</td>
          @endif
          @if (in_array("status_doc", $ColumnShow))
            <td>{{ $pending }}</td>
          @endif
          @if (in_array("detail", $ColumnShow))
          <td>{{ $PPh21 }}</td>
          <td>{{ $PPh4_2 }}</td>
          <td>{{ $PPh15}}</td>
          <td>{{ $PPh22 }}</td>
          <td>{{ $PPh23 }}</td>
          @endif
          
        </tr>
    @endforeach
    </tbody>
</table>