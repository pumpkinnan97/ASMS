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
                        <td><input id="update_ccp_name" type="text" placeholder="必填,此处输入名称或题号" value="{{ $CCP->name }}"></td>
                        <td><input id="update_ccp_description" type="text" placeholder="描述内容" value="{{ $CCP->description }}"></td>
                        <td><input id="update_standard_score" type="text" placeholder="标准分数" value="{{ $CCP->standard_score }}"></td>
                        <td><input id="update_expected_score" type="text" placeholder="期望分数" value="{{ $CCP->expected_score }}"></td>
                    </tr>
                    </tbody>
                </table>
                <button id="update" class="col-md-6 btn btn-success">保存</button>
                <button id="cancel" class="col-md-6 btn btn-brown-alt">取消</button>
        </div>
    </div>
</div>
<script>
    $("#update").click(function () {
        $.ajax({
            type: 'POST',
            url: "{{ url('/CCP')}}/update/{{ $CCP->id }}",
            data: {
                name : $("#update_ccp_name").val(),
                description : $("#update_ccp_description").val(),
                standard_score : $("#update_standard_score").val(),
                expected_score : $("#update_expected_score").val(),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                $.get("{{ url('/CCPs') }}" + "/" + "{{ $CCP->course_code }}" , function(result){
                    $("#module").html(result);
                });
            }
        });
    });
    
    
    $("#cancel").click(function () {
        $("#editCCPDialog").html(' ');
        $("#editCCPDialog").addClass("CCPOpetationDialogClose");
    });
</script>