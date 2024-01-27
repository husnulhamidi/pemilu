<table>
    <thead>
    <tr>
        <th width="10" style="background-color: #00bfff">NO.</th>
        <th width="15" style="background-color: #00bfff">NO PRK</th>
        <th width="15" style="background-color: #00bfff">USER</th>
        <th width="15" style="background-color: #00bfff">OWNER</th>
        <th width="15" style="background-color: #00bfff">KATEGORI</th>
        <th width="30" style="background-color: #00bfff">URAIAN PRK</th>
        <th width="15" style="background-color: #00bfff">ANGGARAN MULTIYEARS</th>
        <th width="15" style="background-color: #00bfff">ANGGARAN OPERASIONAL</th>
        <th width="15" style="background-color: #00bfff">AKO</th>
        <th width="15" style="background-color: #00bfff">REALISASI AKO</th>
        <th width="15" style="background-color: #00bfff">SISA SALDO AKO</th>
        <th width="15" style="background-color: #00bfff">TOTAL NILAI INVOICE</th>
        <th width="15" style="background-color: #00bfff">JENIS</th>
        <th width="15" style="background-color: #00bfff">TAHUN</th>
        <th width="15" style="background-color: #00bfff">TERAKHIR UPDATE</th>

    </tr>
    </thead>
    <tbody>
        @php
         $i=0;   
        @endphp
    @foreach($prk as $prk)
        @php
            $i++;
            $color="black";
            $sisa_ako = $prk['ako']-$prk['nilai_invoice'];
            if($prk['saldo_ako_terpotong']!=$prk['nilai_invoice'] || $sisa_ako!=$prk['saldo_ako']){
                $color="#F0B71E";
            }
        @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $prk['no_prk']}}</td>
            <td>{{ $prk['user']}}</td>
            <td>{{ $prk['owner']}}</td>
            <td>{{ $prk['kategori']}}</td>
            <td>{{ $prk['uraian']}}</td>
            <td>{{ $prk['anggaran_multiyears']}}</td>
            <td>{{ $prk['anggaran_operasi']}}</td>
            <td>{{ $prk['ako']}}</td>
            <td style="color:{{$color}}">{{ $prk['saldo_ako_terpotong']}}</td>
            <td style="color:{{$color}}">{{ $prk['saldo_ako']}}</td>
            <td style="color:{{$color}}">{{ $prk['nilai_invoice']}}</td>
            <td>{{ $prk['jenis']}}</td>
            <td>{{ $prk['tahun']}}</td>
            <td>{{ $prk['date_updated']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>