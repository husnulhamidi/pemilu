<div class="form-group form-md-checkboxes" style="margin-left:5px; margin-top: 10px;">
	<div class="md-checkbox-list">
        @foreach ($data as $menu)
            @php
                if(!empty($menu->menu_action[0]->role_menu_access))
                {
                    $checked1 = "checked='checked'";
                }else{
                    $checked1 = "";
                }
            @endphp
            <div  style="margin-left: 0px">
                <label for="checkbox{{$menu->menu_action[0]->id}}" style="color:#1a0ce9;" class="checkbox checkbox-outline checkbox-success" >
                    <input type="checkbox" id="checkbox{{$menu->menu_action[0]->id}}" class="md-check" name="MenuAccess[]" value="{{$menu->menu_action[0]->id}}" {{$checked1}}>
                    <span></span> &nbsp;&nbsp;{{$menu->title}}
                </label><hr>
            </div>
            @foreach ($menu->menu_action as $ma )
                @php
                    if(!empty($ma->role_menu_access))
                    {
                        $checkedma = "checked='checked'";
                    }else{
                        $checkedma = "";
                    }
                @endphp
                @if ($ma->action_id>1)
                    <div  style="margin-left: 30px">
                        <label for="checkbox{{$ma->id}}" style="color:black;" class="checkbox checkbox-outline checkbox-success">
                            <input type="checkbox" id="checkbox{{$ma->id}}" class="md-check" name="MenuAccess[]" value="{{$ma->id}}" {{$checkedma}}>
                            <span></span> &nbsp;&nbsp;{{$ma->action->action_name}}
                        </label><hr>
                    </div>
                @endif
               
            @endforeach
            @foreach ($menu->submenu as $sm )
                @php
                    if(!empty($sm->menu_action[0]->role_menu_access))
                    {
                        $checkedsm = "checked='checked'";
                    }else{
                        $checkedsm = "";
                    }
                @endphp
                <div  style="margin-left: 30px">
                    <label for="checkbox{{$sm->menu_action[0]->id}}" style="color:#0cd5e9;" class="checkbox checkbox-outline checkbox-success">
                        <input type="checkbox" id="checkbox{{$sm->menu_action[0]->id}}" class="md-check" name="MenuAccess[]" value="{{$sm->menu_action[0]->id}}" {{$checkedsm}}>
                        <span></span> &nbsp;&nbsp;{{$sm->title}}
                    </label><hr>
                </div>

                @foreach ($sm->menu_action as $sma )
                    @php
                        if(!empty($sma->role_menu_access))
                        {
                            $checkedsma = "checked='checked'";
                        }else{
                            $checkedsma = "";
                        }
                    @endphp
                    @if ($sma->action_id>1)
                        <div  style="margin-left: 60px">
                            <label for="checkbox{{$sma->id}}" style="color:black;" class="checkbox checkbox-outline checkbox-success">
                                <input type="checkbox" id="checkbox{{$sma->id}}" class="md-check" name="MenuAccess[]" value="{{$sma->id}}" {{$checkedsma}}>
                                <span></span> &nbsp;&nbsp;{{$sma->action->action_name}}
                            </label><hr>
                        </div>
                    @endif
                @endforeach

            @endforeach

        @endforeach
	</div>
</div>


