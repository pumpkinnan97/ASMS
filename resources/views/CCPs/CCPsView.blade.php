@extends('layouts.app')

@section('content')
<span class="glyphicon glyphicon-chevron-left btn btn-default" style="margin-top: -10px;"></span>
<script>
$(".glyphicon").click(function () {
	if ($(".tree").is(":visible") == true) {
		$(".tree").hide("normal");
		$(this).removeClass("glyphicon-chevron-left").addClass("glyphicon-chevron-right");
		$("#module").removeClass("col-md-8").addClass("col-md-12");
	}
	else{
		$(".tree").show("normal");
		$(this).removeClass("glyphicon-chevron-right").addClass("glyphicon-chevron-left");
		$("#module").removeClass("col-md-12").addClass("col-md-8");
	}
});
</script>
   <div class="tree well col-md-4">

   <button type="button" id="forCIs" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">请选择课程拼音首字母</button>
                   <div class="CIindex">
       <button type="button" id="myButtonA" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">A</button>
       <button type="button" id="myButtonB" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">B</button>
       <button type="button" id="myButtonC" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">C</button>
       <button type="button" id="myButtonD" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">D</button>
       <button type="button" id="myButtonE" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">E</button>
       <button type="button" id="myButtonF" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">F</button>
       <button type="button" id="myButtonG" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">G</button>
       <button type="button" id="myButtonH" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">H</button>
       <button type="button" id="myButtonI" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">I</button>
       <button type="button" id="myButtonJ" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">J</button>
       <button type="button" id="myButtonK" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">K</button>
       <button type="button" id="myButtonL" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">L</button>
       <button type="button" id="myButtonM" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">M</button>
       <button type="button" id="myButtonN" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">N</button>
       <button type="button" id="myButtonO" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">O</button>
       <button type="button" id="myButtonP" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">P</button>
       <button type="button" id="myButtonQ" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">Q</button>
       <button type="button" id="myButtonR" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">R</button>
       <button type="button" id="myButtonS" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">S</button>
       <button type="button" id="myButtonT" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">T</button>
       <button type="button" id="myButtonU" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">U</button>
       <button type="button" id="myButtonV" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">V</button>
       <button type="button" id="myButtonW" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">W</button>
       <button type="button" id="myButtonX" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">X</button>
       <button type="button" id="myButtonY" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">Y</button>
       <button type="button" id="myButtonZ" data-loading-text="Loading..." class="btn btn-default" autocomplete="off">Z</button>
			<div>
                    @foreach($Courses as $course)
                    <li>
                        <span class="coursename btn-default"><i class="icon-minus-sign"></i></span>
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
                </div>
        </div>
    </div>
        <script src="{{ URL::asset('/js/pinyin.js') }}"></script>
    <script>
    $(function() {
    	$(".coursename").parent().hide();
        var coursearr = [];
        @foreach($Courses as $course)
        coursearr.push(["{{ $course->name }}","{{ $course->course_code }}"]);
        @endforeach
        coursearr.sort(compare);
        //按首字母拼音排序
        for (let i = 0; i < coursearr.length; i++) {
            $(".coursename").find("i").eq(i).after(coursearr[i][0]);
            //添加课程名
            $(".coursename").eq(i).parent().attr("class","Initial"+Pinyin.getCamelChars(coursearr[i][0]).charAt(0));
            //将课程名拼音首字母信息作为class标识
            $(".coursename").eq(i).next().find("li span").attr("data-code",coursearr[i][1]);
            //添加课程代码，便于从后台获取数据
        }
    });
    </script>
            </li>
        </ul>
    </div>

    <div id="module" class="col-md-8"></div>

    <script type="text/javascript">
    $('#forGRs').click(function (){
            markSelected(this);
            $.get("{{ url('/GRs') }}" , function(result){
                $("#module").html(result);
            });
        });
        $('#forCIs').click(function () {
            $('.CIindex').toggle();
            //点击CI切换A~Z标识是否可见
        });
        $('.CIindex>button').click(function () {
            var CIinitial = "Initial"+$(this).attr("id").charAt(8);
            //找到课程名的首字母
            $(".parent_li").hide();
            $("."+CIinitial).show();
            $(".coursename").click();
        })
        // $('#forGRs').click(function (){
        //     markSelected(this);
        //     $.get("{{ url('/GRs') }}" , function(result){
        //         $("#module").html(result);
        //     });
        // });
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
