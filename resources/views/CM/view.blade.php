<div class="col-md-7">
    <h1 class="text-center"><strong>CM相关信息</strong></h1>
    <table class="table table-hover">
        <th>CM代码</th>
        <th>CM名称</th>
        <th>课程代码</th>
        <th>描述</th>
        <th>对应CO</th>
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
            </tr>
            @endforeach
    </table>
</div>
<!-- <form method="post" action="{{url("/CMs/$course_code")}}" >
    <p>请选择CM模块</p>
    <select name="cm_code" id="cm_code">
        <option>CM1</option>
        <option>CM2</option>
        <option>CM3</option>
        <option>CM4</option>
        <option>CM5</option>
        <option>CM6</option>
        <option>CM7</option>
        <option>CM8</option>
    </select>
    <p>请填写CM名称</p>
    <input name="name" id="name">
    <p>请填写CM英文名称</p>
    <input name="EN_name" id="EN_name">
    <p>请选择对应的CO信息</p>
    @for($i=1;$i<=$count;$i++)
        <select name="{{$i}}" id="CM_CO">
            <option value=""> 空</option>
            @foreach($COs as $CO)
            <option value="{{$CO->name}}">{{$CO->name}}</option>
                @endforeach
        </select>
        @endfor
    <p>请填写描述</p>
    <input type="text" name="description" id="description">
    <p>请填写英文描述</p>
    <input type="text" name="english_description" id="description">
    <input type="submit">
</form> -->
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
        <input name="english_description" id="description" class="form-control">
      </div>
      <input type="submit" id="courseSubmit" class="btn btn-default"></input>
    </form>
</div>