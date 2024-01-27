<div class="form-group form-md-checkboxes" style="margin-left:5px; margin-top: 10px;">
	<div class="md-checkbox-list">
        @php
            $MenuID = "";
            $i=1;
        @endphp
        @foreach ($data as $action => $act)
            @php
                if($act->menu_id!=""){
                    $checked = 'checked="checked"';
                }else{
                    $checked = '';
                }
            @endphp
            <div class="checkbox-inline">
                <label class="checkbox checkbox-outline checkbox-success">
                    <input type="checkbox" id="checkbox{{$i}}" class="md-check" name="ActionID[]" value="{{$act->id}}" {{$checked}}>
                    <span></span> {{$act->action_name}}
                </label>
            </div>
            @php
                $i++;
            @endphp
        @endforeach
		<?php 
			
			/*foreach($access as $k=>$v){
                if($v['MenuActionID']!=''){
                    $checked = 'checked="checked"';
                }else{
                    $checked = '';
                }
                $style = "color:#1a0ce9;";
                
				echo '<div class="checkbox-inline">
						<label class="checkbox checkbox-outline checkbox-success">
							<input type="checkbox" id="checkbox'.$i.'" class="md-check" name="ActionID[]" value="'.$v['ActionID'].'" '.$checked.'>
							<span></span> '.$v['ActionName'].'
						</label>
					</div>';
                $i++;
			}*/
		?>
	</div>
</div>


