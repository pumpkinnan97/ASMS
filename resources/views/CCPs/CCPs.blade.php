{{--{{$CCPs->toJson()}}--}}
<div class="col-md-12">
    <div class="col-md-12">
        <div class="panel panel-default">
        <!--<div class="panel-heading">上传CCP文件</div>
            <div class="panel-body">
                <form action="{{url('/upload') }}/{{ $course_code }}/ccpTemp" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input class="btn btn-danger-alt" type="file" name="file"><br/><br/>
                    <input class="btn btn-success" type="submit" value="提交"/>
                    <input id="cancel" class="btn btn-brown-alt col-md-3" type="button" value="取消"/>
                </form>
            </div>
        </div>-->
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">课程考核点管理(CCP)</div>
        <div class="panel-body">
            <div id="ccp_root" class="tree well col-md-12">
            </div>
            <div id="addCCPDialog" class="col-md-8"></div>
            <div id="addRootCCPDialog" class="col-md-8"></div>
            <div id="editCCPDialog" class="col-md-8"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
//        test();
        initRoot("#ccp_root", "课程考核点管理(CCP)-ROOT");
        parseTreeByCCPS();
        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
        $('.tree li.parent_li > span').on('click', function(e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
            }
            e.stopPropagation();
        });
    });

    $('#addRootCCP').click(function () {
        $.ajax({
            url: "{{ url('/addRootCCP') }}/{{ $course_code }}",
            type: 'GET',
            success: function(result){
//                console.log(result);
                $("#addRootCCPDialog").html(result);
                $("#addRootCCPDialog").removeClass("CCPOpetationDialogClose");
                $("#addRootCCPDialog").addClass("CCPOpetationDialogOn");
            }
        });
    });

    $(".viewDetail").click(function(){
        var id = $(this).attr('data-ccp-id');
        if($("#" + id).css('display') == 'none')
        {
            $("#" + id).css({'display' : 'block'});
        } else {
            $("#" + id).css({'display' : 'none'});
        }
    });

    $(".add").click(function(){
        $.get("{{ url('/addCCP') }}" + '/' + $(this).attr('data-ccp-id'), function(result){
            $("#addCCPDialog").html(result);
            $("#addCCPDialog").removeClass("CCPOpetationDialogClose");
            $("#addCCPDialog").addClass("CCPOpetationDialogOn");
        });
    });

    $(".changeable").click(function(){
        $.get("{{ url('/editCCP') }}/" + $(this).attr('data-ccp-id'), function(result){
            $("#editCCPDialog").html(result);
            $("#editCCPDialog").removeClass("CCPOpetationDialogClose");
            $("#editCCPDialog").addClass("CCPOpetationDialogOn");
        });
    });

    $(".delete").click(function(){
        $.ajax({
            url: "{{ url('/CCP') }}" + '/' + $(this).attr('data-ccp-id'),
            type: 'DELETE',
            success: function(result){
//                console.log(result);
                $.get("{{ url('/CCPs') }}" + "/" + "{{ $course_code }}" , function(result){
                    $("#module").html(result);
                });
            }
        });
    });


    function test() {
        initRoot("#ccp_root", "课程考核点管理(CCP)-ROOT");
        insert("#ccp_0", "期中考试", "ccp_1");
        insert("#ccp_0", "期末考试", "ccp_2");
        insert("#ccp_0", "实验", "ccp_3");
        insert("#ccp_0", "作业", "ccp_4");

        insert("#ccp_1", "选择", "ccp_2_1");
        insert("#ccp_1", "填空", "ccp_2_2");
        insert("#ccp_1", "解答", "ccp_2_3");

        insert("#ccp_2_1", "选择题1", "ccp_2_1_1");
    }
    //生成根节点
    function initRoot(rootNode, rootName) {
        $(rootNode).append('<ul><li><span>' + rootName +
                '</span>' +
                '<button id="addRootCCP" type="button" class="btn btn-default"><img class="ccp_opreation_icon" src="{{ URL::asset('/images/icon/add.png') }}"></button>' +
                '<ul id="ccp_0"></ul></li></ul>');
    }
    //生成节点
    function insert(rootNode, rootName, pccpCode, ccpId, ccpDescription,standard_score) {
        $(rootNode).append('<li><span>' + rootName + '('+ standard_score + '分)' +
                '<p id='+ ccpId +' style="display:none">' + ccpDescription + '</p></span>' +
                '<button type="button" class="delete btn btn-default" data-ccp-id="' + ccpId + '" data-ccp-code="' + pccpCode + '"><img class="ccp_opreation_icon" src="{{ URL::asset('/images/icon/delete.png') }}"></button>' +
                '<button type="button" class="changeable btn btn-default" data-ccp-id="' + ccpId + '" data-ccp-code="' + pccpCode + '"><img class="ccp_opreation_icon" src="{{ URL::asset('/images/icon/change.png') }}"></button>' +
                '<button type="button" class="add btn btn-default" data-ccp-id="' + ccpId + '" data-ccp-code="' + pccpCode + '"><img class="ccp_opreation_icon" src="{{ URL::asset('/images/icon/add.png') }}"></button>' +
                '<button type="button" class="viewDetail btn btn-default" data-ccp-id="' + ccpId + '" data-ccp-code="' + pccpCode + '"><img class="ccp_opreation_icon" src="{{ URL::asset('/images/icon/view.png') }}"></button>' +
                '<ul  id=' +pccpCode + '></ul></li>');
    }
    //生成CCP树
    function parseTreeByCCPS() {
        var ccps = JSON.parse('{!!$CCPs!!}');
        var i;
        ccps = sortList('level', ccps);
        for(i = 0; i<ccps.length; i++){
            var ccp = ccps[i];
            if(ccp.level == 0){
                insert("#ccp_0", ccp.name, ccp.ccp_code, ccp.id, ccp.description);
            }else{
                //找到最后一个"_"
                var index = ccp.ccp_code.lastIndexOf('_');
                //找到父节点
                var node = ccp.ccp_code.substring(0, index);
                insert('#'+node.toString(), ccp.name, ccp.ccp_code, ccp.id, ccp.description,ccp.standard_score);
            }
        }
    }

    function sortList (sortBy, list) {
        return list.sort(function(a, b) {
            // 升序
            return a[sortBy] - b[sortBy];
        });
    }
</script>

<style>
    .CCPOpetationDialogOn{
        position: fixed;
        top: 250px;
        left: 100px;
        z-index: 999;
        display: block;
    }
    .CCPOpetationDialogClose{
        display: none;
    }
    .ccp_opreation_icon{
        height: 12px;
        width: 12px;
    }
</style>