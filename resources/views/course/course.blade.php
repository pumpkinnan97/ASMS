<!-- <form action="{{url('/addCourse')}}" method="post" role="form">
    <div class="form-group">  
        <p>请选择学期</p>
        <select name="term" id="term">
            <option value="2015-2016_1_">2015-2016第一学期</option>
            <option value="2015-2016_2_">2015-2016第二学期</option>
        </select>
    </div>
    <p>请填写课程代码</p>
    <input name="course_code" id="course_code">
    <p>请填写课程名称</p>
    <input name="name" id="name">
    <p>请填写英文名称</p>
    <input name="english_name" id="english_name">
    <p>请填写学时</p>
    <input name="total_hours" id="total_hours">
    <p>请填写学分</p>
    <input name="credit" id="credit">
    <p>请选择课程类型</p>
    <select name="type" id="type">
        <option>学科基础课</option>
        <option>核心通识课</option>
    </select>
    <p>填写属于学科</p>
    <input name="major" id="major">
    <p>请填写前置课程（无则空）</p>
    <input name="prerequisite_course" id="prerequisite_course">
    <p>请填写中文描述</p>
    <input type="text" name="description" id="description">
    <p>请填写英文描述</p>
    <input name="english_description" id="english_description">
    <p>请填写所在课程组</p>
    <input name="course_group" id="course_group">
    <p>作者</p>
    <input name="author" id="author">
    <p>考核方式</p>
    <input name="test_way" id="test_way">
    <p>建议书籍</p>
    <input name="advice_books" id="advice_books">
    <p>请填写课程教师</p>
    <input name="cd_name" id="cd_name">
    <input type="submit">
</form> -->
<form action="{{url('/addCourse')}}" method="post" role="form">
  <div class="form-group">
    <label>请选择学期</label>
    <select name="term" id="term" class="form-control">
            <option value="2015-2016_1_">2015-2016第一学期</option>
            <option value="2015-2016_2_">2015-2016第二学期</option>
    </select>
  </div>
  <div class="form-group">
    <label>请填写课程代码</label>
    <input name="course_code" id="course_code" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写课程名称</label>
    <input name="name" id="name" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写英文名称</label>
    <input name="english_name" id="english_name" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写学时</label>
    <input name="total_hours" id="total_hours" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写学分</label>
    <input name="credit" id="credit" class="form-control">
  </div>
  <div class="form-group">
    <label>请选择课程类型</label>
    <select name="type" id="type" class="form-control">
        <option>学科基础课</option>
        <option>核心通识课</option>
    </select>
  </div>
  <div class="form-group">
    <label>填写属于学科</label>
    <input name="major" id="major" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写前置课程（无则空）</label>
    <input name="prerequisite_course" id="prerequisite_course" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写中文描述</label>
    <input name="description" id="description" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写英文描述</label>
    <input name="english_description" id="english_description" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写所在课程组</label>
    <input name="course_group" id="course_group" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写作者</label>
    <input name="author" id="author" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写考核方式</label>
    <input name="test_way" id="test_way" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写建议书籍</label>
    <input name="advice_books" id="advice_books" class="form-control">
  </div>
  <div class="form-group">
    <label>请填写课程教师</label>
    <input name="cd_name" id="cd_name" class="form-control">
  </div>
  <button type="submit" class="btn btn-default">提交</button>
</form>