<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">课程目标管理(CO)</div>

        <div class="panel-body">
            <table class="table" contenteditable="false">
            CO 
            <button type="button" class="forEditCOs btn btn-default">编辑</button>
            {{--<button type="button" class="btn btn-default">提交</button>--}}
                <thead>
                    <tr>
                        <th>名称</th>
                        <th>描述</th>
                        <th>权重</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($COs as $CO)
                        <tr>
                            <td>{{ $CO->name }}</td>
                            <td>{{ $CO->description }}</td>
                            <td data-test="{{ $CO->CO_GR_as_weight }}" class="test">{{ $CO->CO_GR_as_weight }}</td>
                            <!-- <script>
                            var test = $(".test").attr("data-test");
                                console.log(test);
                            </script> -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="editCOsDialog"></div>
<script>
    //<td>{{ $CO->CO_GR_as_weight }}</td>
</script>
<script>
    $(".forEditCOs").click(function () {
        var course_code = "{{ $course_code }}";
        $.get("{{url( '/editCOs') }}" + "/" + course_code, function (result) {
            $("#module").html(result);
        })
    });
</script>