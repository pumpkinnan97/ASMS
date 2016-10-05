@extends('layouts.app')

@section('content')
   <div class="tree well col-md-3">
        <ul>
            <li>
                <span id="forGRs"class="icon-folder-open"><i class="icon-folder-open"></i>毕业要求指标(GR)</span>
                <ul>
                   <li><span id="editGRs"><i class="icon-minus-sign"></i>修改毕业要求(EDITGRs)</span></li>
                    <li><span id="addGRs"><i class="icon-minus-sign"></i>新增毕业要求(ADDGRs)</span></li>
                    <li><span id="addGRCourses"><i class="icon-minus-sign"></i>添加GR关联课程(ADDGRCourses)</span></li>
                </ul>
            </li>
            <li>
                <span id="show"><i class="icon-folder-open"></i>添加课程信息(ADDCourse)</span>
            </li>
            <li>
                <span><i class="icon-folder-open"></i>课程信息管理(CI)</span>
                <ul>
                    @foreach($Courses as $course)
                    <li>
                        <span><i class="icon-minus-sign"></i>{{ $course->name }}</span>
                        <ul>
                            {{--<li>--}}
                                {{--<span ><i class="icon-leaf"></i>教学大纲(Syllabus)</span></span>--}}
                            {{--</li>--}}
                            <li>
                                <span class="forCOs" data-code="{{ $course->course_code }}"><i class="icon-leaf"></i>课程目标管理(CO)</span></span>
                            </li>
                            <li>
                                <span class="forCMs" data-code="{{$course->course_code}}"><i class="icon-leaf">课程模块信息管理(CM)</i> </span></span>
                            </li>
                            <li>
                                <span class="forCCPs" data-code="{{ $course->course_code }}"><i class="icon-leaf"></i>课程考核点管理(CCP)</span></span>
                            </li>
                            <li>
                                <span class="forCOsAndCCPs" data-code="{{ $course->course_code }}"><i class="icon-leaf"></i>CO达成度相关CCP管理</span></span>
                            </li>
                            <li>
                                <span class="forGRsAndCCPs" data-code="{{ $course->course_code }}"><i class="icon-leaf"></i>GR达成度相关CCP管理</span></span>
                            </li>
                            <li>
                                <span class="forStudentsCCPs" data-code="{{ $course->course_code }}"><i class="icon-leaf"></i>学生CCP数据管理</span></span>
                            </li>
                            <li>
                                <span class="forStudentsCO_GR" data-code="{{ $course->course_code }}"><i class="icon-leaf"></i>CO&GR达成度计算</span></span>
                            </li>
                        </ul>
                        </span>
                    </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>

    <div id="module" class="col-md-9"></div>

    <script type="text/javascript">
        $('#forGRs').click(function (){
            markSelected(this);
            $.get("{{ url('/GRs') }}" , function(result){
                $("#module").html(result);
            });
        });
        $('#addGRs').click(function (){
            markSelected(this);
            $.get("{{ url('/addGRs') }}" , function(result){
                $("#module").html(result);
            });
        });
        $('#show').click(function () {
           markSelected(this);
            $.get("{{url('/show')}}",function (result) {
                $("#module").html(result);
            });
        });
        $('.forCOs').click(function (){
            var course_code = $(this).attr('data-code');
            markSelected(this);
            $.get("{{ url('/COs') }}/" + course_code, function(result){
                $("#module").html(result);
            });
        });
        $('.forCMs').click(function () {
           var course_code=$(this).attr('data-code');
            markSelected(this);
            $.get("{{url('CMs')}}/"+course_code,function (result) {
                $("#module").html(result);
            });
        });
        $('.forCCPs').click(function (){
            var course_code = $(this).attr('data-code');
            markSelected(this);
            $.get("{{ url('/CCPs') }}/" + course_code , function(result){
                $("#module").html(result);
            });
        });
        $('#editGRs').click(function () {
            markSelected(this);
            $.get("{{url('/editGRs')}}",function (result) {
                $("#module").html(result);
            })
        });
        $('.forCOsAndCCPs').click(function () {
            var course_code = $(this).attr('data-code');
            markSelected(this);
            $.get("{{ url('/getCOsAndCCPs') }}/" + course_code , function(result){
                $("#module").html(result);
            });
        });

        $('.forGRsAndCCPs').click(function () {
            var course_code = $(this).attr('data-code');
//            $(this).css({ 'background-color' :  'lightgreen'});
            markSelected(this);
            $.get("{{ url('/getGRsAndCCPs') }}/" + course_code , function(result){
                $("#module").html(result);
            });
        });

        $('.forStudentsCCPs').click(function () {
            var course_code = $(this).attr('data-code');
            markSelected(this);
            $.get("{{ url('/getStudentsCCPs') }}/" + course_code , function(result){
                $("#module").html(result);
            });
        });
        $('#addGRCourses').click(function () {
            markSelected(this);
            $.get("{{url('/addGRCourses')}}",function (result) {
                $("#module").html(result);
            })
        })
        $('.forStudentsCO_GR').click(function () {
            var course_code = $(this).attr('data-code');
            markSelected(this);
            $.get("{{ url('/getStudentsCOGR') }}/" + course_code , function(result){
                $("#module").html(result);
            });
        });

        //选中元素变色
        function markSelected(obj)
        {
            // $('.forCOs').css({ 'background-color' :  ''});
            // $('.forCCPs').css({ 'background-color' :  ''});
            // $('.addCourse').css({ 'background-color' :  ''});
            // $('.forCOsAndCCPs').css({ 'background-color' :  ''});
            // $('.forGRsAndCCPs').css({ 'background-color' :  ''});
            // $('.forStudentsCCPs').css({ 'background-color' :  ''});
            // $('.forStudentsCO_GR').css({ 'background-color' :  ''});
            // $('#editGRs').css({ 'background-color' :  ''});
            // $('#addGRs').css({ 'background-color' :  ''});
            $(".tree li span").css({ 'background-color' :  '#eee'});
            $(obj).css({ 'background-color' :  'lightgreen'});
            scrollToTop();
        }

        //跳转到顶端
        function scrollToTop() {
            $('html,body').animate({scrollTop: $("#app-layout").offset().top}, 100);
        }
    </script>
@endsection
