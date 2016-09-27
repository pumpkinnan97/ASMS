<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">课程目标考查点关系(GR-CCP)管理</div>

        <div class="panel-body">
            <table class="table" contenteditable="false">
                GR-CCP
                {{--<button type="button" class="btn btn-default">提交</button>--}}
                <thead>
                <tr>
                    <th>名称</th>
                    <th>描述</th>
                    <th>关联CCP</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($GRsAndCCPs as $GRAndCCPs)
                    <tr>
                        <td>{{ $GRAndCCPs->name }}</td>
                        <td>{{ $GRAndCCPs->ise_description }}</td>
                        <td>{{ $GRAndCCPs->gr_as_weight }}</td>
                        <td><button type="button" class="forEditGRAndCCPs btn btn-default" data-gr-code="{{ $GRAndCCPs->gr_code }}">编辑</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(".forEditGRAndCCPs").click(function () {
        var gr_code = $(this).attr('data-gr-code');
        var course_code = '{!! $course_code !!}';
        $.get("{{url( '/editGRAndCCPs') }}" + "/" + gr_code +  "/course/" + course_code, function (result) {
            $("#module").html(result);
        })
    });
</script>