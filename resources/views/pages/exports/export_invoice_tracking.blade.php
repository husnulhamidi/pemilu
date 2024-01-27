
    <table border="1">
        
        @php
            //echo json_encode($invoices);die;
        @endphp
        @foreach ($invoices as $inv)
        <thead>
            <tr>
                <th width='15' align="center" style="background-color: #00bfff">NO.INVOICE</th>
                <th width='20' align="center" style="background-color: #00bfff">TANGGAL INVOICE</th>
                <th width='28' align="center" style="background-color: #00bfff">NAMA VENDOR</th>
                <th width='25' align="center" style="background-color: #00bfff">NO. KONTRAK / PO/PK</th>
                @foreach ($inv->history as $key)
                    <th width='25' align="center" style="background-color: #00bfff">{{$key->pengirim}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
           
                <tr>
                    <td height='15'>{{$inv->no_invoice}}
                    <td height='15'>{{date('d-M-y',strtotime($inv->tgl_invoice))}}
                    <td height='15'>{{$inv->nama_vendor}}
                    <td height='15'>{{$inv->no_kontrak}}
                    @foreach($inv->history as $key => $his )
                            <td height='15'>{{date('d-M-y',strtotime($his->created_at))}}</td>
                    @endforeach
                </tr>
           
            
        </tbody>
        @endforeach
        
       
    </table>


