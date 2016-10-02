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
            <th>选择CO对应GR(最多四个)</th>
            <th>操作</th>
        </tr>
        <tbody>
        @foreach ($COs as $CO)
                <tr>
                    <td><p class="changeable" type="text" placeholder="指标名称" value="{{ $CO->name }}" data-co-id="{{ $CO->id }}" data-co-code="{{ $CO->co_code }}" data-type="name">{{ $CO->name }}</p></td>
                    <td><p class="changeable" type="text" placeholder="描述" value="{{ $CO->description }}"  data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}" data-type="description">{{ $CO->description }}</p></td>
                    <td><p class="changeable" type="text" placeholder="英文描述" value="{{ $CO->english_description }}"  data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}" data-type="english_description">{{ $CO->english_description }}</p></td>
                    <td><p class="changeable" type="text" placeholder="标准值" value="{{ $CO->achivement_scale }}" data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}" data-type="achivement_scale">{{ $CO->achivement_scale }}</p></td>
                    <td><p class="changeable" type="text" placeholder="期望值" value="{{$CO->expected_scale}}" data-co-code="{{$CO->co_code}}" data-co-id="{{$CO->id}}" data-type="expected_scale">{{$CO->expected_scale}}</p></td>
                    <td><p class="changeable" type="text" placeholder="CO对应GR权重" value="{{ $CO->CO_GR_as_weight }}" data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}" data-type="CO_GR_as_weight">{{ $CO->CO_GR_as_weight }}</p></td>
                    <td><button id="{{ $CO->id }}" class="delete btn-danger" data-co-code="{{ $CO->co_code }}" data-co-id="{{ $CO->id }}">删除</button></td>
                </tr>
        @endforeach
                <tr>
                    <input id="#new_co_code" type="hidden" value="{{ $new_CO_id }}">
                    <td><select name="name" id="name">
                            <option value="CO1">CO1</option>
                            <option value="CO2">CO2</option>
                            <option value="CO3">CO3</option>
                            <option value="CO4">CO4</option>
                            <option value="CO5">CO5</option>
                            <option value="CO6">CO6</option>
                            <option value="CO7">CO7</option>
                            <option value="CO8">CO8</option>
                        </select> </td>
                    <td><input id="description" type="text" placeholder="填写中文描述"></td>
                    <td><input id="en_description" type="text" placeholder="填写英文描述"></td>
                    <td><input id="achivement_scale" type="text" placeholder="编辑标准值"></td>
                    <td><input id="expected_scale" type="text" placeholder="编辑期望值"></td>
                    <td>
                        <select id="CO_GR1">
                            <option value="">无</option>
                            @foreach($TOGRs as $GR)
                                <option value="{{$GR->gr_code}}">{{$GR->gr_code}}</option>
                            @endforeach
                                <input id="weight1" type="text" placeholder="编辑此CO对应GR权重">
                        </select>
                        <select id="CO_GR2">
                            <option value="">无</option>
                            @foreach($TOGRs as $GR)
                                <option value="{{$GR->gr_code}}">{{$GR->gr_code}}</option>
                            @endforeach
                            <input id="weight2" type="text" placeholder="编辑此CO对应GR权重">
                        </select>
                        <select id="CO_GR3">
                            <option value="">无</option>
                            @foreach($TOGRs as $GR)
                                <option value="{{$GR->gr_code}}">{{$GR->gr_code}}</option>
                            @endforeach
                            <input id="weight3" type="text" placeholder="编辑此CO对应GR权重">
                        </select>
                        <select id="CO_GR4">
                            <option value="">无</option>
                            @foreach($TOGRs as $GR)
                                <option value="{{$GR->gr_code}}">{{$GR->gr_code}}</option>
                            @endforeach
                            <input id="weight4" type="text" placeholder="编辑此CO对应GR权重">
                        </select>
                    </td>
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
                CO_GR1 : $("#CO_GR1").val(),
                CO_GR2 : $("#CO_GR2").val(),
                CO_GR3 : $("#CO_GR3").val(),
                CO_GR4 : $("#CO_GR4").val(),
                weight1 :$("#weight1").val(),
                weight2 : $("#weight2").val(),
                weight3 : $("#weight3").val(),
                weight4 : $("#weight4").val()
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
