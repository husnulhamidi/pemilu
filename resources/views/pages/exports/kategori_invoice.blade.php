
    <table border="1">
        <thead>
        <tr>
            <th width='5' align="center">NO</th>
            <th width='10' align="center">ID</th>
            <th width='28' align="center">URAIAN</th>
            <th width='25' align="center">ADA / TIDAK</th>
            <th width='25' align="center">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
            @php
                $i=0;
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
                    <td>{{$check->id}}</td>
                    <td>{{$check->uraian}}</td>
                    <td align="center">
                        {{$checked}}
                    </td>
                    <td>{{$check->keterangan}}</td>
                
                </tr>
            @endforeach
        </tbody>
    </table>


