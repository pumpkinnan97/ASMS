<div class="col-md-7">
    <h1 class="text-center"><strong>CM相关信息</strong></h1>
    <table class="table table-hover">
        <th>CM代码</th>
        <th>CM名称</th>
        <th>课程代码</th>
        <th>描述</th>
        <th>对应CO</th>
        <th>操作</th>
        @foreach($CMs as $CM)
            <tr>
                <td>
                    {{$CM->cm_code}}
                </td>
                <td>
                    {{$CM->name}}
                </td>
                <td>
                    {{$CM->course_code}}
                </td>
                <td>
                {{$CM->description}}
                <td>
                    <?php
                    $CM_COs=DB::select("select co_code from cm_cos where cm_code=?",[$CM->cm_code]);
                    foreach ($CM_COs as $CM_CO){
                        echo $CM_CO->co_code;
                        echo "、";
                    }
                    ?>
                </td>
                <td>
                    <form method="post" action="{{url("/deleteCM/$CM->cm_code")}}"><input type="submit" value="删除"></form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
<div class="col-md-5">
    <h1 class="text-center"><strong>添加CM</strong></h1>
    <form>
        <div class="form-group">
            <label>请选择CM模块</label>
            <select name="cm_code" id="cm_code" class="form-control">
                <option>CM1</option>
                <option>CM2</option>
                <option>CM3</option>
                <option>CM4</option>
                <option>CM5</option>
                <option>CM6</option>
                <option>CM7</option>
                <option>CM8</option>
            </select>
        </div>
        <div class="form-group">
            <label>请填写CM名称</label>
            <input name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label>请填写CM英文名称</label>
            <input name="EN_name" id="EN_name" class="form-control">
        </div>
        <div class="form-group">
            <label>请选择对应的CO信息</label>
            @for($i=1;$i<=$count;$i++)
                <select name="{{$i}}" id="CM_CO" class="form-control">
                    <option value="">空</option>
                    @foreach($COs as $CO)
                        <option value="{{$CO->name}}">{{$CO->name}}</option>
                    @endforeach
                </select>
            @endfor
        </div>
        <div class="form-group">
            <label>请填写描述</label>
            <input name="description" id="description" class="form-control">
        </div>
        <div class="form-group">
            <label>请填写英文描述</label>
            <input name="english_description" id="english_description" class="form-control">
        </div>
    </form>
    <input type="submit" id="CMSubmit" class="btn btn-default"></input>
</div>
<script>
    $("#CMSubmit").click(function () {
        $.ajax({
            type: "POST",
            url: "/CMs/"+"{{$course_code}}",
            data: {
                cm_code : $("#cm_code").find("option:selected").text(),
                name: $("#name").val(),
                EN_name: $("#EN_name").val(),
                CM_CO: $("#CM_CO").find("option:selected").text(),
                description: $("#description").val(),
                english_description: $("#english_description").val(),
            },
            success : function (data) {
                alert("成功填写！");
            },
            error : function (data) {
                alert("失败,原因可能为选择了重复的CM模块或中英文描述不符合要求！");
            }
        });
    });
</script>