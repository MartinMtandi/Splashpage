
    <?php $y = 0; ?>
    <?php $i = 0; ?>
    <input type="hidden" name="group_id" value="{{$data[0]->group_id}}" />
  
    @foreach($data as $qstn)
            <?php $y += 1; ?>
            <?php $i += 1; ?>
            <label><strong>{{$qstn->question}}</strong></label>
            <input type="hidden" name="qstn[{{$qstn->id}}]" value="{{$qstn->id}}" />
            @if($qstn->control_id == 1)
                <!----.INPUT FIELD---->
                <input type="text" class="form-control_id mb-3" name="answer-{{$qstn->id}}[{{$y}}]" style="width:100%;">
            @elseif($qstn->control_id == 2)
                <!----.TEXT AREA---->
                <textarea class="form-control rounded-0" rows="3" name="answer-{{$qstn->id}}[{{$y}}]" style="width:100%;"></textarea>
            @elseif($qstn->control_id == 3)
                <!----.RADIO BUTTONS---->          
                @foreach(json_decode($qstn->answers, true) as $answer => $value)
                    @foreach($value as $key => $val)
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="defaultRadioUnchecked{{$key}}" name="answer-{{$qstn->id}}[{{$y}}]" value="{{$key}}">
                            <label class="custom-control-label" for="defaultRadioUnchecked{{$key}}">{{$val}}</label>
                        </div>
                    @endforeach
                @endforeach
            @elseif($qstn->control_id == 4)
                <!----.CHECK BOX---->
                @foreach(json_decode($qstn->answers, true) as $answer => $value)
                    @foreach($value as $key => $val)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultCheckBoxUnchecked{{$key}}" name="answer-{{$qstn->id}}[{{$y++}}]" value="{{$key}}">
                        <label class="custom-control-label" for="defaultCheckBoxUnchecked{{$key}}">{{$val}}</label>
                    </div>
                    @endforeach
                @endforeach
            @elseif($qstn->control_id == 5)
                <!----.DROPDOWN MENU---->
                <select class="browser-default custom-select mb-2" name="answer-{{$qstn->id}}[{{$y}}]">
                    <option></option>
                    @foreach(json_decode($qstn->answers, true) as $answer => $value)
                        @foreach($value as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
                        @endforeach
                    @endforeach
                </select>
            @endif
    @endforeach
