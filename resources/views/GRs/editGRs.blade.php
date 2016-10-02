
            <table>
                <thead>
                <tr>
                    <th>指标编号</th>
                    <th>名称</th>
                    <th>原始描述</th>
                    <th>自定义描述</th>
                    <th>子项GR对应父项权重</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($GRs as $GR)
                    <tr>
                        <td>{{ $GR->gr_code }}</td>
                        <form  method="post" action="{{url("/editGRs/$GR->gr_code")}}">
                        <td><input name="name" type="text" placeholder="填写指标名称" value="{{ $GR->name }}"></td>
                        <td><input name="standart_description" type="text" placeholder="填写原始描述" value="{{$GR->standart_description}}"> </td>
                        <td><input name="ise_description" type="text" placeholder="添加自定义描述" value="{{ $GR->ise_description }}"></td>
                        <td><input name="gr_ALLGR_weight" type="text" placeholder="编辑指标权重" value="{{ $GR->gr_ALLGR_weight }}"></td>
                        <td><input type="submit" value="保存"></td>
                            </form>
                    </tr>
                @endforeach
                </tbody>
            </table>



