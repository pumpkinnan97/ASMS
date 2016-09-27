<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">导入课程考核点（CCP）配置</div>
        <div class="panel-body">
            <form action="{{ url('/upload') }}/{{ $course_code }}/ccps" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="course_code" value="{{ $course_code }}">
                <input class="btn btn-danger-alt" type="file" name="file"><br/><br/>
                <input class="btn btn-success" type="submit" value="提交"/>
                <input id="cancel" class="btn btn-brown-alt col-md-3" type="button" value="取消"/>
            </form>
        </div>
    </div>
</div>
<script>
    $("#cancel").click(function () {
        $.get("{{ url('/getStudentsCCPs') }}/" + "{{ $course_code }}" , function(result){
            $("#module").html(result);
        });
    });
</script>
