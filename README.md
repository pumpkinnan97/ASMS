# 电子科技大学ASMS(Achievement Scale Management System)系统

该项目为前端基于bootstrap框架构建，通过jQuery Ajax与后台进行交互。后台则采用基于laravel框架的架构，连接MySQL数据库。

## 使用方法

解压根目录下的vendor.zip至根目录下，在装有php5.0+及MySQL的主机上，并导入asms.sql数据库

运行

```
php artisan serve
```

通过`http://localhost:8000`进入本项目

## 相关目录说明

- server.php：项目入口文件，由laravel框架所生成。
- package.json：通过gulp进行打包的前端模块化配置文件。
- composer.json：Composer的相关配置文件
- public/
  - js/：存放本项目前端部分运行的js代码（包括bootstrap、jQuery等）
  - css/：存放本项目前端部分运行的css代码（包括bootstrap、jQueryUI等）
  - font/：存放本项目字体
  - images/：存放本项目图片
- resources/
  - views/：存放本项目视图文件
- database/: 项目数据库相关文件
- app/: 存放本项目后端部分文件
  - Http/：路由控制文件

## 相关名词说明

- GR: 毕业要求达成度，其下属有GR子项，如GR1.1、GR1.2等。
- CO: 课程目标达成度
- CM: 课程模块
- CCP: 课程考核点管理，其下属有CCP子项，如CCP1.1、CCP1.2等，分别关联学生平时成绩、期中成绩、实验成绩、期末成绩等。

## 对应关系

GR->GR子项->CO->CCP