
            <table class="table table-hover">
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
                    <tr class="postGRs">
                        <td class="GRgr_code">{{ $GR->gr_code }}</td>
                        <!-- <form  method="post" action="{{url("/editGRs/$GR->gr_code")}}"> -->
	                    <td><input name="name" type="text" placeholder="填写指标名称" value="{{ $GR->name }}" class="GRname form-control"></td>
	                    <td><input name="standart_description" type="text" placeholder="填写原始描述" value="{{$GR->standart_description}}" class="GRstandart_description form-control"> </td>
	                    <td><input name="ise_description" type="text" placeholder="添加自定义描述" value="{{ $GR->ise_description }}" class="GRise_description form-control"></td>
	                    <td><input name="gr_ALLGR_weight" type="text" placeholder="编辑指标权重" value="{{ $GR->gr_ALLGR_weight }}" class="GRgr_ALLGR_weight form-control"></td>
	                    <td><input type="submit" value="保存" class="submitGRs btn btn-default "></td>
                        <!-- </form> -->
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="alert alert-warning GRalert" style="position: absolute; left: 30%;top: 10%;">
				<a href="#" class="close">
					&times;
				</a>
				<strong>权重值必须为0至1！</strong>
				<br>
				<strong>请重新设定权重值</strong>
			</div>
            <script>
            	$(".GRalert a").click(function () {
            		$(".GRalert").hide();
            	});
            	$(".GRalert").hide();
            	$(".submitGRs").click(function () {
            		var GRgr_ALLGR_weight = $(this).parent().parent().find(".GRgr_ALLGR_weight").val();
            		if (GRgr_ALLGR_weight<0||GRgr_ALLGR_weight>1) {
            			$(".GRalert").show("fast");
            			return;
            		};

            		$.ajax({
            			type: "POST",
            			url: "/editGRs/" + $(this).parent().parent().find(".GRgr_code").text(),
            			dataType: "json",
            			data: {
            				gr_ALLGR_weight: $(this).parent().parent().find(".GRgr_ALLGR_weight").val(),
            				name : $(this).parent().parent().find(".GRname").val(),
            				standart_description: $(this).parent().parent().find(".GRstandart_description").val(),
            				ise_description: $(this).parent().parent().find(".GRise_description").val()
            			},
            			success : function (data) {
            				alert("成功");
            			},
            			error : function (data) {
            				alert(data.responseText);
            			}
            		});
            	});
            </script>



