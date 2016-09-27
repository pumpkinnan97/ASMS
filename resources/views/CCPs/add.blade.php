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
                </tr>

                <tbody>
                <tr>
                    <td><input id="ccp_name" type="text" placeholder="必填,此处输入名称或题号"></td>
                    <td><input id="ccp_description" type="text" placeholder="描述内容"></td>
                    <td><input id="standard_score" type="text" placeholder="标准分数"></td>
                    <td><input id="expected_score" type="text" placeholder="期望分数"></td>
                </tr>
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