<div class="col-md-12">
<div class="panel panel-default">
    <div class="panel-heading">课程目标管理(CO)
        <button style="float: right;" id="save" class="btn btn-success">验证权重百分比</button>
    </div>
    <table class="table-bordered">
        <tr>
            <th>名称</th>
            <th>中文描述</th>
            <th>英文描述</th>
            <th>标准值</th>
            <th>预期值</th>
            <th>CO对应GR权重</th>
            <th>操作</th>
        </tr>
        <tbody>
        @foreach ($COs as $CO)
                <tr>
                    <td><input class="changeable" type="text" placeholder="填写指标名称" value="{{ $CO->name }}" data-co-id="{{ $CO->id }}" data-co-code="{{ $CO->co_code }}" data-type="name"></td>
                    <td><input class="changeable" type="text" placeholder="描述" value="{{ $CO->description }}"  data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}" data-type="description"></td>
                    <td><input class="changeable" type="text" placeholder="英文描述" value="{{ $CO->english_description }}"  data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}" data-type="english_description"></td>
                    <td><input class="changeable" type="text" placeholder="编辑标准值" value="{{ $CO->achivement_scale }}" data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}" data-type="achivement_scale"></td>
                    <td><input class="changeable" type="text" placeholder="编辑期望值" value="{{$CO->expected_scale}}" data-co-code="{{$CO->co_code}}" data-co-id="{{$CO->id}}" data-type="expected_scale"> </td>
                    <td><input class="changeable" type="text" placeholder="编辑CO对应GR权重" value="{{ $CO->CO_GR_as_weight }}" data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}" data-type="CO_GR_as_weight"></td>
                    <td><button id="{{ $CO->id }}" class="delete btn-danger" data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}">删除</button></td>
                </tr>
        @endforeach
                <tr>
                    <input id="#new_co_code" type="hidden" value="{{ $new_CO_id }}">
                    <td><input id="name" type="text" placeholder="填写指标名称" value=""></td>
                    <td><input id="description" type="text" placeholder="填写中文描述"></td>
                    <td><input id="en_description" type="text" placeholder="填写英文描述"></td>
                    <td><input id="achivement_scale" type="text" placeholder="编辑标准值"></td>
                    <td><input id="expected_scale" type="text" placeholder="编辑期望值"></td>
                    <td><input id="weight" type="text" placeholder="编辑此CO对应GR权重"></td>
                    <td><input id="create" type="submit" value="添加" class="btn-block" data-course-code="{{ $course_code }}"></td>
                </tr>
        </tbody>
    </table>
</div>
</div>
<script>
    //创建新CO
    $('#create').click(function () {
        $.ajax({
            type: 'POST',
            url: "{{ url('/COs')}}" + '/' + "{{ $course_code }}",
            data: {
                name : $("#name").val(),
                description : $("#description").val(),
                english_description : $("#en_description").val(),
                CO_GR_as_weight : $("#weight").val(),
                expected_scale : $("#expected_scale").val(),
                achivement_scale : $("#achivement_scale").val(),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                console.log(data);
                $.get("{{url( '/editCOs') }}" + "/{{ $course_code }}", function (result) {
                    $("#module").html(result);
                })
            },
            error: function(data){
                console.log(data);
            }
        });
    });

    $('#save').click(function () {
        $.get("{{ url('/validateCOWeightSum') }}" + "/" + "{{ $course_code }}", function(result){
            console.log(result);
            var re = JSON.parse(result);
            if(re.status == "true")
            {
                alert("success");
            } else {
                alert("failed");
            }
            $.get("{{ url('/COs') }}/" + "{{ $course_code }}", function(result){
                $("#module").html(result);
            });
        });
    });

    //提交数据修改
    $('.changeable').change(function () {
        var co_id = $(this).attr('data-co-id');
        var data_type = $(this).attr('data-type');
        $.ajax({
            type: 'POST',
            url: "{{ url('/COs') }}" + "/update/" + co_id,
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
        var course_code = "{{ $course_code }}";
        $.get("{{url( '/editCOs') }}" + "/" + course_code, function (result) {
            $("#module").html(result);
        })
    });


    //提交数据修改
    $('.delete').click(function () {
        var co_id = $(this).attr('data-co-id');
        $.ajax({
            type: 'DELETE',
            url: "{{ url('/COs') }}" + "/" + co_id,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
//                console.log(data.status);
                $.get("{{url( '/editCOs') }}" + "/{{ $course_code }}", function (result) {
                    $("#module").html(result);
                })

            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    })
</script>
