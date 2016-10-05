<div class="col-md-5">
    <table class="table table-hover">
        <tr>
            <th>GR名称</th>
            <th>对应课程</th>
            <th>操作</th>
        </tr>
        @foreach($GRs as $GR)
        <tr>
            <td>{{$GR->name}}</td>
            <td><?php
                $gr_courses=\Illuminate\Support\Facades\DB::select("SELECT * FROM gr_courses where gr_code=?",[$GR->gr_code]);
                    foreach ($gr_courses as $gr_course){
                        echo $gr_course->course_code;
                        echo "、";
                    }
            ?></td>
            <td><form action="{{url("deleteGRCourse/$GR->gr_code")}}" method="post">
                <input type="submit" value="删除关联信息" class="btn-danger btn">
            </form></td>
        </tr>
            @endforeach
    </table>
</div>
<div class="col-md-7">
    <table class="table table-hover">
        <tr>
            <th>GR名称</th>
            <th>课程名称</th>
            <th>操作</th>
        </tr>
        <form method="post" action="{{url("/addGRCourse")}}">
        <tr>
            <td>
                <select name="GR_name" class="form-control">
                    @foreach($GRs as $GR)
                        <option value="{{$GR->name}}">{{$GR->name}}</option>
                    @endforeach
                </select>
            </td>
            <td><select name="Course_name" class="form-control">
                    @foreach($courses as $course)
                        <option value="{{$course->name}}">{{$course->course_code}}{{$course->name}}</option>
                        @endforeach
                </select> </td>
            <td>
                <input type="submit" value="添加" class="btn btn-default">
            </td>
        </tr>
            </form>
    </table>
</div>