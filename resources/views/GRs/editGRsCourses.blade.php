<div>
    <button class="btn btn-success">保存</button>
    <table class="table-bordered">
        <tr>
            <th>课程名称</th>
            <th>课程权重</th>
            <th>操作</th>
        </tr>

        @foreach($courses as $course)
            <tr>
                <td>{{ $course['name'] }}</td>
                <td><input class="changeable" type="number" max="3" value="{{ $course['weight'] }}" data-gr-code="{{ $gr_code }}" data-type="cs_to_gr_as_weight" data-course-code="{{ $course['code'] }}"></td>
                <td><button class="delete btn-danger" data-course-code="{{ $course['code'] }}">删除</button></td>
            </tr>
        @endforeach
            <tr>
                <td>选择课程(TODO)</td>
                <td><input type="number" max="3" placeholder="此处输入权重" value=""></td>
                <td><button class="btn-success" data-gr-code="{{ $gr_code }}">添加</button></td>
            </tr>
    </table>
</div>
<script>
    //提交数据修改
    $('.changeable').change(function () {
        var gr_code = $(this).attr('data-gr-code');
        var data_type = $(this).attr('data-type');
        var course_code = $(this).attr('data-course-code');
        $.ajax({
            type: 'POST',
            url: "{{ url('/COs') }}" + "/update/" + gr_code + "/course/" + course_code,
            data: {
                data_type : data_type,
                data : $(this).val(),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                $.get("{{url( '/editCOs') }}" + "/{{ $course_code }}", function (result) {
                    $("#module").html(result);
                })
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    });
</script>