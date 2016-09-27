<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">CO达成度相关CCP管理</div>

        <div class="panel-body">
            <table class="table table-bordered" contenteditable="false">
                CO-CCP
                {{--<button type="button" class="btn btn-default">提交</button>--}}
                <thead>
                <tr>
                    <th>名称</th>
                    <th>描述</th>
                    <th>权重</th>
                    {{--<th>高关联度CCP</th>--}}
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($COsAndCCPs as $COAndCCPs)
                    <tr>
                        <td>{{ $COAndCCPs->name }}</td>
                        <td>{{ $COAndCCPs->description }}</td>
                        <td>{{ $COAndCCPs->co_as_weight }}</td>
                        <td><button type="button" class="forEditCOAndCCPs btn btn-default" data-co-id="{{ $COAndCCPs->id }}">编辑</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(".forEditCOAndCCPs").click(function () {
        var co_id = $(this).attr('data-co-id');
        $.get("{{url( '/editCOAndCCPs') }}" + "/" + co_id, function (result) {
            $("#module").html(result);
        })
    });
</script>