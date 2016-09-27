<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">【XX学年】《{{$course_name}}》CO&GR达成度计算</div>

        <div class="panel-body">
            <table class="table" contenteditable="false">
                课程目标达成度评价表(CO_AS)
                <thead>
                <tr>
                    <th>课程目标</th>
                    <th>对CO达成度的支持权重</th>
                    <th>目标描述</th>
                    {{--<th>达成度目标值</th>--}}
                    <th>达成度评价值</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($COs as $CO)
                    <tr>
                        <td>{{ $CO->name }}</td>
                        <td>{{ $CO->co_as_weight }}</td>
                        <td>{{ $CO->description }}</td>
                        {{--<td>{{ $CO->expected_score_percent }}</td>--}}
                        <td>{{ $CO->real_score_percent }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <table class="table" contenteditable="false">
                【XX学年】《{{$course_name}}》课程毕业要求达成度评价表
                <thead>
                <tr>
                    <th>毕业要求分解指标项</th>
                    <th>指标项说明</th>
                    <th>本课程对GR达成度的支持权重</th>
                    {{--<th>本课程GR相关CCP达成度<font color="#EE9A00">目标值</font>的加权叠加</th>--}}
                    {{--<th>本课程GR相关CCP达成度<font color="#EE9A00">评价值</font>的加权叠加</th>--}}
                    <th>本课程GR相关CCP累加达成度评价值</th>
                    {{--<th>达成度目标值</th>--}}
                    <th>达成度评价值</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($GRs as $GR)
                    <tr>
                        <td>{{ $GR->name }}</td>
                        <td>{{ $GR->ise_description }}</td>
                        <td>{{ $GR->gr_as_weight }}</td>
                        {{--<td>{{ $GR->expected_score_percent }}</td>--}}
                        <td>{{ $GR->real_score_percent }}</td>
                        {{--<td>{{ $GR->expected_score_percent_weight }}</td>--}}
                        <td>{{ $GR->real_score_percent_weight }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="editCOsDialog"></div>
