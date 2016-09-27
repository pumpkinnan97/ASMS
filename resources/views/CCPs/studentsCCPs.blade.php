<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">学生CCP管理</div>

        <div style="overflow-x:scroll" class="panel-body">
            <table class="table" contenteditable="false">
                <button type="button" id="downloadStudentsCCPs" class="btn btn-default">导出模板</button>
                <button type="button" id="uploadStudentCCPs"class="btn btn-default">导入数据</button>
                <thead>
                <tr>
                    <th>学生学号</th>
                    <th>学生姓名</th>
                    @foreach($leafCCPsName as $ccpName)
                        <th>{{$ccpName['name']}}-{{$ccpName['id']}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('#downloadStudentsCCPs').click(function () {
        window.location.href="{{ url('/download') }}/" + "{{$course_code}}" + "/students_ccps";
    });
    $('#uploadStudentCCPs').click(function () {
        $.get("{{ url('/upLoadCCP') }}/{{$course_code}}", function(result){
            $("#module").html(result);
        });
    })
</script>