<table border="1">
    <thead>
    <tr>
        <th colspan="2">Mata Uang</th>
        <th colspan="3">: {{$currency}}</th>
    </tr>
    <tr>
        <th colspan="2">Bank</th>
        <th colspan="3">: {{$bank}}</th>
    </tr>
    <tr>
        <th colspan="2">No. Cek / BG</th>
        <th colspan="3">: {{$no_cek}}</th>
    </tr>
    <tr>
        <th colspan="2">Periode</th>
        <th colspan="3">: {{date('d-m-Y',strtotime($date_start))." s/d ".date('d-m-Y',strtotime($date_end))}}</th>
    </tr>
    <tr>
        <th colspan="2">Tanggal Export</th>
        <th colspan="3">: {{date('d-m-Y')}}</th>
    </tr>
    <tr>
        <th colspan="6" height="20px"></th>
    </tr>
   
    <tr >
        <th width="60px" align="center" style="background-color: #00bfff">NO.</th>
        <th width="120px" align="center" style="background-color: #00bfff">TANGGAL</th>
        <th width="120px" align="center" style="background-color: #00bfff">NO CEK / BG</th>
        <th width="200px" align="center" style="background-color: #00bfff">NAMA VENDOR</th>
        <th width="200px" align="center" style="background-color: #00bfff">URAIAN</th>
        <th width="120px" align="center" style="background-color: #00bfff">DANA MASUK</th>
        <th width="120px" align="center" style="background-color: #00bfff">DANA KELUAR</th>
        {{-- <th width="120px" align="center" style="background-color: #00bfff">SALDO AKHIR</th>
        <th width="120px" align="center" style="background-color: #00bfff">SALDO AWAL ORI</th> --}}
        <th width="120px" align="center" style="background-color: #00bfff">SALDO AKHIR</th>
        <th width="120px" align="center" style="background-color: #00bfff">PARAF AMN KEU</th>
        <th width="155px" align="center" style="background-color: #00bfff">PARAF MSB KEU DAN AKT</th>
        <th width="120px" align="center" style="background-color: #00bfff">PARAF SRM KKU</th>
    </tr>
    </thead>
    <tbody>
    @php
     $i=0;
     $saldo = $saldo_awal;   
     $saldo_awal_ori = 0;
     $saldo_akhir_ori = 0;
    @endphp
    @foreach($invoices as $inv)
        @php
           $i++; 
           if($inv->tipe=='in'){
                $saldo = $saldo+$inv->dana_masuk;
            }else{
                $saldo = $saldo-$inv->dana_keluar;
            }
            if($i==1){
                $saldo_awal_ori = (float) $inv->saldo_awal;
            }

            $saldo_akhir_ori = (float) $inv->saldo_akhir;
            
        @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>{{ date('d-m-Y',strtotime($inv->tanggal)) }}</td>
            <td>{{ $inv->no_cek }}</td>
            <td>{{ $inv->nama_vendor?$inv->nama_vendor:'' }}</td>
            <td>{{ $inv->keterangan }}</td>
            <td>{{ (float) $inv->dana_masuk }}</td>
            <td>{{ (float) $inv->dana_keluar }}</td>
            {{-- <td>{{ (float) $saldo>0?(float) $saldo:"" }}</td>
            <td>{{ (float) $inv->saldo_awal }}</td> --}}
            @if ($no_cek!="")
                <td>{{ (float) $inv->saldo_akhir }}</td>
            @else
                <td>{{ (float) $saldo>0?(float) $saldo:"" }}</td>
            @endif
            
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    <tr>
        <th colspan="6" height="40px"></th>
    </tr>
    <tr>
        <th ></th>
        <th ></th>
        <th ></th>
        <th ></th>
        <th style="background-color: #00bfff" align="center">SALDO AWAL</th>
        <th style="background-color: #00bfff" align="center">DANA MASUK</th>
        <th style="background-color: #00bfff" align="center">DANA KELUAR</th>
        <th style="background-color: #00bfff" align="center">SALDO AKHIR</th>
    </tr>

    @if ($no_cek!="")
        <tr>
            <th ></th>
            <th ></th>
            <th ></th>
            <th ></th>
            <th >{{(float) $saldo_awal_ori>0?$saldo_awal_ori:$saldo_akhir_ori+$out}}</th>
            <th >{{(float) $in}}</th>
            <th >{{(float) $out}}</th>
            <th >{{(float) $saldo_akhir_ori}}</th>
        </tr>
    @else
        <tr>
            <th ></th>
            <th ></th>
            <th ></th>
            <th ></th>
            {{-- <th >{{(float) $saldo_awal}}</th> --}}
            <th >{{(float) $out+(float) $saldo_akhir}}</th>
            <th >{{(float) $in}}</th>
            <th >{{(float) $out}}</th>
            <th >{{(float) $saldo_akhir}}</th>
        </tr>
    @endif
    
    <tr>
        <th colspan="6" height="20px"></th>
    </tr>
    </tbody>
    
</table>