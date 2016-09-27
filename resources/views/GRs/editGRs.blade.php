<div>
            <table class="table table-bordered" contenteditable="false">
                <thead>
                <tr>
                    <th>指标编号</th>
                    <th>名称</th>
                    <th>原始描述</th>
                    <th>自定义描述</th>
                    <th>权重</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($GRs as $GR)
                    <tr>
                        <td>{{ $GR->gr_code }}</td>
                        <td><input type="text" placeholder="填写指标名称" value="{{ $GR->name }}"></td>
                        <td>{{ $GR->standart_description }}</td>
                        <td>{{ $GR->ise_description }}</td>
                        <td><input type="text" placeholder="编辑指标权重" value="{{ $GR->gr_as_weight }}"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <button class="btn btn-success save">保存</button>
</div>

<script>
//TODO
    $('.save').click(function(){
        $.get("{{ url('/GRs') }}" , function(result){
            $("#module").html(result);
        });
    });
</script>

