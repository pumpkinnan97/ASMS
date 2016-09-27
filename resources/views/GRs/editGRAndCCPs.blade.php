{{--{{$CCPs->toJson()}}--}}
<div id="ccp_root" class="tree well col-md-12">
</div>
<button id="saveCOCCP" class="btn btn-success">保存</button>


<script type="text/javascript">
    $(function() {
        initRoot("#ccp_root", "课程达成度)");
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


    //生成根节点
    function initRoot(rootNode, rootName) {
        $(rootNode).append('<ul><li><span>' + rootName +
                '</span><ul id="ccp_0"></ul></li></ul>');
    }
    //生成节点
    function insert(rootNode, rootName, ccpCode, isLeafCpp, ccpId, ccpName,value,level,standard_score) {
        if(isLeafCpp == 1 && level != 0){
            if(parseInt(value) > 0){
                $(rootNode).append('<li><label>' +
                        '<input type="checkbox" class="" checked=checked data-ccp-id="' + ccpId + '" data-ccp-name="' + ccpName + '"/>'+
                        '<span>' + rootName + '('+ standard_score + '分)' +
                        '</span>&nbsp;' +
                        '</label>' +
                        '<input id="weight_' + ccpId + '" type="text" class="weight hidden-input" value="'+ value +'" style="width:60px;"/>'+
                        '<ul  id=' +ccpCode + ' class="ccpNode" data-ccp-code=' + ccpCode + '></ul></li>');

            }else{
                $(rootNode).append('<li><label>' +
                        '<input type="checkbox" class="" data-ccp-id="' + ccpId + '" data-ccp-name="' + ccpName + '"/>'+
                        '<span>' + rootName + '('+ standard_score + '分)' +
                        '</span>&nbsp;' +
                        '</label>' +
                        '<input id="weight_' + ccpId + '" type="text" class="weight hidden-input" value="'+ value +'" style="width:60px;"/>'+
                        '<ul  id=' +ccpCode + ' class="ccpNode" data-ccp-code=' + ccpCode + '></ul></li>');
            }
        }else if(isLeafCpp == 0 || level == 0) {
            $(rootNode).append('<li><span>' + rootName + '('+ standard_score + '分)' +
                    '</span>&nbsp;' +
                    '<input id="weight_' + ccpId + '" type="text" class="weight hidden-input" value="0" style="width:60px; " disabled="disabled"/>'+
                    '<ul  id=' +ccpCode + ' class="ccpNode" data-ccp-code=' + ccpCode + '></ul></li>');
        }

    }

    //生成CCP树
    function parseTreeByCCPS() {
        var ccps = JSON.parse('{!!$CCPs!!}');
        var i;
        ccps = sortList('level', ccps);
        for(i = 0; i<ccps.length; i++){
            var ccp = ccps[i];
            if(ccp.level == 0){
                insert("#ccp_0", ccp.name, ccp.ccp_code, ccp.is_leaf_ccp, ccp.id, ccp.name,0,ccp.level,ccp.standard_score);
            }else{
                //找到最后一个"_"
                var index = ccp.ccp_code.lastIndexOf('_');
                //找到父节点
                var node = ccp.ccp_code.substring(0, index);
                insert('#'+node.toString(), ccp.name, ccp.ccp_code, ccp.is_leaf_ccp, ccp.id, ccp.name,ccp.value,ccp.level,ccp.standard_score);
            }
        }
    }

    function sortList (sortBy, list) {
        return list.sort(function(a, b) {
            // 升序
            return a[sortBy] - b[sortBy];
        });
    }

    $('.weight').blur(function () {

        //两位小数：/^[0](.[0-9]{1,2})?$/
        //0-100整数
        if( !(parseInt(this.value) >= 0 && parseInt(this.value) <= 100) ){
            alert("请输入0-100之间整数");
            this.value = '0';
        }else{
            if(parseInt(this.value) != 0){
                $(this).prev().children("input").attr("checked","checked");
                $(this).prev().children("input").removeAttr("disabled");
                updatePnodeWeight(this);
            }
        }
    })

    $('#saveCOCCP').click(function () {
        var selectedCCP = [];
        $("input:checked").each(function () {
            var item = {
                "ccp_id" : $(this).attr('data-ccp-id'),
                "ccp_name" : $(this).attr('data-ccp-name'),
//                "weight" : $('#weight_' + $(this).attr('data-ccp-id')).val()
            }

            selectedCCP.push(item);
        });
        var course_code = '{!! $course_code !!}';
        var gr_code = '{!! $gr_code !!}';
        $.ajax({
            type: 'POST',
            url: "{{ url('/GRs/bind')}}" + "/" + gr_code +  "/course/" + course_code,
            data: {
                selectedCCP : selectedCCP
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                console.log(data);
                {{--$.get("{{url( '/editCOs') }}" + "/{{ $course_code }}", function (result) {--}}
                {{--$("#module").html(result);--}}
                {{--})--}}
            },
            error: function(data){
                console.log(data);
            }
        });

    });

    function updatePnodeWeight(obj) {

        //获取父级ul的id
        var pNodeId = $(obj).parent().parent('.ccpNode').attr('data-ccp-code');
//        alert(pNodeId);
        var pWeight = 0;
        //父级ul的每一个input孩子
        $('#' + pNodeId).children("li").children("input").each(function () {
            pWeight += parseInt($(this).val());
        });
        if(pWeight > 100){
            alert("错误的权重！请修改");
        }
        //父级ul的input
        $('#' + pNodeId).prev().attr("value", pWeight);
//        alert($('#' + pNodeId).prev().val());

        if(pNodeId != "{{$course_code}}_ccp"){
            console.log("di");
            updatePnodeWeight('#' + pNodeId);
        }
    }
</script>

<style>
    .hidden-input {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }

    input[type=checkbox]+span {

    }

    input[type=checkbox]:checked+span {
        background-color: lightgreen;
    }

    label{
        font-weight: normal;
    }

</style>