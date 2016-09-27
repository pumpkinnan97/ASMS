<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">毕业要求指标(GR)</div>
        <div class="panel-body">
            <table class="table table-bordered" contenteditable="false">

                {{--<button type="button" class="forEditGRs btn btn-default">编辑</button>--}}
                {{--<button type="button" class="btn btn-default">提交</button>--}}
                <thead>
                <tr>
                    {{--<th>指标编号</th>--}}
                    <th>名称</th>
                    <th>原始描述</th>
                    <th>自定义描述</th>
                    {{--<th>权重</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach ($GRs1 as $GRAt1)
                    <tr>
{{--                        <td>{{ $GRAt1->gr_code }}</td>--}}
                        <td>{{ $GRAt1->name }}</td>
                        <td>{{ $GRAt1->standart_description }}</td>
                        <td>{{ $GRAt1->ise_description }}</td>
{{--                        <td>{{ $GRAt1->gr_as_weight }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>



            @foreach($GRDetails as $GR)
                <table class="table table-bordered" contenteditable="false">
                    {{--{{ $GR['level1']->gr_code }}--}}
                    {{ $GR['level1']->name }}
                    {{ $GR['level1']->standart_description }}
                    {{--<button type="button" class="btn btn-default">编辑</button>--}}
                    {{--<button type="button" class="btn btn-default">提交</button>--}}
                    <thead>
                    <tr>
                        {{--<th>指标编号</th>--}}
                        <th>名称</th>
                        <th class="col-md-2">原始描述</th>
                        <th class="col-md-2">自定义描述</th>
                        <th class="col-md-3">高关联度课程</th>
                        <th>权重</th>
                        {{--<th>操作</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($GR['level2'] as $childGRInfo)
                        <tr>
{{--                            <td>{{ $childGRInfo['gr']->gr_code }}</td>--}}
                            <td>{{ $childGRInfo['gr']->name }}</td>
                            <td>{{ $childGRInfo['gr']->standart_description }}</td>
                            <td>{{ $childGRInfo['gr']->ise_description }}</td>
                            <td>
                                <table>
                                    <tr>
                                        <th>课程名称</th>
                                        <th>权重</th>
                                    </tr>
                                    @foreach($childGRInfo['courses'] as $course)
                                        <tr>
                                            <td>{{ $course['name'] }}</td>
                                            <td>{{ $course['weight'] }}</td>
                                        </tr>
                                    @endforeach

                                </table>
                            </td>
                            <td>{{ $childGRInfo['gr']->gr_as_weight }}</td>
                            {{--<td><button class="forEditGRsCourses btn btn-default" type="button" data-gr-code="{{ $childGRInfo['gr']->gr_code }}">编辑关联课程</button></td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
</div>

<div id="editGRsCoursesDialog"></div>
<div id="editGRsDialog"></div>

<script>
    $('.forEditGRsCourses').click(function () {
        var gr_code = $(this).attr('data-gr-code');
        $.get("{{ url('/GR') }}" + "/" + gr_code, function(result){
            $("#editGRsCoursesDialog").html(result);
            $("#editGRsCoursesDialog").dialog({width: 500, height: 400});
        });
    });

    $('.forEditGRs').click(function () {
        $.get("{{ url('/editGRs') }}", function (result) {
            $('#editGRsDialog').html(result);
            $("#editGRsDialog").dialog({width: 900, height: 400});
        })
    })
</script>

