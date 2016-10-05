        <style>
            table th,table td {
                text-align: center;
            }
            input::-ms-input-placeholder{text-align: center;} 
            input::-webkit-input-placeholder{text-align: center;} 

        </style>
        <table class="table-bordered table table-hover">
            <tr>
                <th>GR代码</th>
                <th>子项GR名称</th>
                <th>原始描述</th>
                <th>自定义描述</th>
                <th>对应父项GR权重</th>
                <th>操作</th>
            </tr>
            <tbody>
            @foreach ($GRs as $GR)
                <tr>
                    <td><p class="changeable" type="text" placeholder="指标代码" value="{{ $GR->gr_code }}" data-gr-code="{{ $GR->gr_code }}" data-type="gr_code">{{ $GR->gr_code }}</p></td>
                    <td><p class="changeable" type="text" placeholder="名称" value="{{ $GR->name }}"  data-gr-code="{{ $GR->gr_code }}" data-type="name">{{ $GR->name }}</p></td>
                    <td><p class="changeable" type="text" placeholder="原始描述" value="{{ $GR->standart_description }}" data-gr-code="{{ $GR->gr_code }}" data-type="standart_description">{{ $GR->standart_description }}</p></td>
                    <td><p class="changeable" type="text" placeholder="自定义描述" value="{{$GR->ise_description}}" data-gr-code="{{$GR->gr_code}}" data-type="ise_description">{{$GR->ise_description}}</p></td>
                    <td><p class="changeable" type="text" placeholder="指标权重" value="{{ $GR->gr_ALLGR_weight }}" data-gr-code="{{ $GR->gr_code }}" data-type="gr_ALLGR_weight">{{ $GR->gr_ALLGR_weight }}</p></td>
                    <td><button id="{{ $GR->gr_code }}" class="delete btn-danger btn" data-gr-code="{{ $GR->gr_code }}">删除</button></td>
                </tr>
            @endforeach
            <tr>
                <td><input id="gr_code" name="gr_code" type="text" placeholder="请填写GR代码"></td>
                <td><input id="name" name="name" type="text" placeholder="请填写GR名称"></td>
                <td><input id="standart_description" type="text" placeholder="填写原始描述"></td>
                <td><input id="ise_description" type="text" placeholder="填写自定义描述"></td>
                <td><input id="gr_ALLGR_weight" type="text" placeholder="填写对应父项GR权重"></td>
                <td><input id="create" type="submit" value="添加" class="btn btn-default"></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
    <script>
    $("#create").click(function () {
        $.ajax({
            type: 'POST',
            url: "{{ url('/addGR')}}",
            data: {
                gr_code : $("#gr_code").val(),
                name : $("#name").val(),
                standart_description : $("#standart_description").val(),
                ise_description : $("#ise_description").val(),
                gr_ALLGR_weight : $("#gr_ALLGR_weight").val()
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                console.log(data);
                $.get("{{url( '/addGRs') }}", function (result) {
                    $("#module").html(result);
                })
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $('.delete').click(function () {
        var gr_code = $(this).attr('data-gr-code');
        $.ajax({
            type: 'DELETE',
            url: "{{ url('/deleteGR') }}" + "/" + gr_code,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
//                console.log(data.status);
                $.get("{{url( '/addGRs') }}", function (result) {
                    $("#module").html(result);
                })

            },
            error: function(xhr, type){
                alert('删除未成功，请联系系统管理员！');
            }
        });
    })

</script>
