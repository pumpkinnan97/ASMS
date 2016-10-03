<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">增加信息</div>

        <div class="panel-body">
            <table class="table" contenteditable="false">
                <tr>
                    <th>名称/题号</th>
                    <th>描述</th>
                    <th>标准分数</th>
                    <th>期望分数</th>
                    <th>设置对应CO权重</th>
                    <th>设置对应GR权重</th>
                </tr>

                <tbody>
                <tr>
                    <td><input name="ccp_name" id="ccp_name" type="text" placeholder="必填,此处输入名称或题号"></td>
                    <td><input name="ccp_description" id="ccp_description" type="text" placeholder="描述内容"></td>
                    <td><input name="standard_score" id="standard_score" type="text" placeholder="标准分数"></td>
                    <td><input name="expected_score" id="expected_score" type="text" placeholder="期望分数"></td>
                    <td>
                        @for($i=1;$i<=$COcount;$i++)
                        <select name="{{'CO'.$i}}" id="{{'CO'.$i}}">
                                <option value="">无</option>
                            @foreach($COs as $CO)
                            <option value="{{$CO->co_code}}">{{$CO->name}}</option>
                                @endforeach
                        </select>
                            <input name="{{'CO_weight'.$i}}" id="{{'CO_weight'.$i}}" type="text" placeholder="请输入对应CO权重">
                            @endfor
                    </td>
                    <td>
                        @for($i=1;$i<=$GRcount;$i++)
                            <select name="{{'GR'.$i}}" id="{{'GR'.$i}}">
                                    <option value="">无</option>
                                @foreach($GRs as $GR)
                                    <option value="{{$GR->gr_code}}">{{$GR->gr_code}}</option>
                                @endforeach
                            </select>
                            <input name="{{'GR_weight'.$i}}" id="{{'GR_weight'.$i}}" type="text" placeholder="请输入对应GR权重">
                        @endfor
                </tbody>

            </table>
            <button id="create" class="col-md-6 btn btn-success">保存</button>
            <button id="cancel" class="col-md-6 btn btn-brown-alt">取消</button>
        </div>
    </div>
</div>
<script>
    //创建新CCP
    $('#create').click(function () {
        $.ajax({
            type: 'POST',
            url: "{{ url('/CCP')}}/{{ $ccp_code }}",
            data: {
                ccp_code : "{{ $ccp_code }}",
                name : $("#ccp_name").val(),
                description : $("#ccp_description").val(),
                standard_score : $("#standard_score").val(),
                expected_score : $("#expected_score").val(),
                is_leaf_ccp : 1,
                parent_ccp_id : "{{ $parent_ccp_id }}",
                CO1 : $("#CO1").val(),
                CO_weight1 : $("#CO_weight1").val(),
                CO2 : $("#CO2").val(),
                CO_weight2 : $("#CO_weight2").val(),
                CO3 : $("#CO3").val(),
                CO_weight3 : $("#CO_weight3").val(),
                CO4 : $("#CO4").val(),
                CO_weight4 : $("#CO_weight4").val(),
                GR1 : $("#GR1").val(),
                GR_weight1 : $("#GR_weight1").val(),
                GR2 : $("#GR2").val(),
                GR_weight2 : $("#GR_weight2").val(),
                GR3 : $("#GR3").val(),
                GR_weight3 : $("#GR_weight3").val(),
                GR4 : $("#GR4").val(),
                GR_weight4 : $("#GR_weight4").val()
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
//                if (data.status == 'true'){
                    $("#addCCPDialog").html(' ');
                    $.get("{{ url('/CCPs') }}" + "/" + "{{ $course_code }}" , function(result){
                        $("#module").html(result);
                    });
//                } else {
//                    alert("错误:" + data.info);
//                }
            },
            error: function(data){

            }
        });
    });

    $("#cancel").click(function () {
        $("#addCCPDialog").html(' ');
        $("#addCCPDialog").addClass("CCPOpetationDialogClose");
    });
</script>