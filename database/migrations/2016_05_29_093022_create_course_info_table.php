<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_infos', function (Blueprint $table) {
            $table->string('course_code', 64);
            $table->primary('course_code');
            $table->string('name', 64);
            $table->string('english_name', 1024);
            $table->integer('total_hours');
            $table->string('credit', 32);
            $table->string('type', 32);
            $table->string('major', 32);
            $table->string('course_group',64);
            $table->string('prerequisite_course', 255);
            $table->text('description');
            $table->text('english_description');
            $table->float('co_achievement_scale');
            $table->string('author',32);
            $table->string('test_way',32);
            $table->text('advice_books');
            $table->date('edit_date');
        });

        Schema::create('gr_courses', function (Blueprint $table) {
            $table->string('gr_code', 64);
            $table->string('course_code', 64);
            $table->float('cs_to_gr_as_weight');

            $table->primary(['course_code', 'gr_code']);
        });

        Schema::create('student_ccps', function (Blueprint $table) {
            $table->string('ccp_code', 64);
            $table->string('student_id',13);
            $table->float('score', 3);
            $table->primary(['ccp_code','student_id']);
        });
        Schema::create('student_GRs',function(Blueprint $table){
           $table->increments('id');
            $table->string('student_id');
            $table->string('course');
            $table->float('ccp_GR');
            $table->float('ccp_CO_GR');
        });
        Schema::create('ccp_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ccp_code', 64);
            $table->string('course_code', 64);
            $table->integer('is_leaf_ccp');
            $table->string('name', 64);
            $table->string('description', 64);
            $table->double('standard_score');
            $table->double('expected_score');
            $table->double('actual_score');
            $table->integer('level');
            $table->string('ccp_CO_weight');
            $table->string('ccp_GR_weight');
        });
        Schema::create('cm_cos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cm_code', 64);
            $table->string('co_code', 64);

        });
        Schema::create('co_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('co_code', 64);
            $table->string('course_code', 64);
            $table->string('name', 64);
            $table->text('description');
            $table->text('english_description');
            $table->float('achivement_scale');
            $table->float('expected_achievement_scale');
            $table->string('CO_GR_weight');
            $table->float('ccp_CO_rest_weight')->default(1.00);
        });
        Schema::create('gr_infos', function (Blueprint $table) {
            $table->string('gr_code', 64);
            $table->string('name', 64);
            $table->string('standart_description', 1024);
            $table->string('ise_description', 1024);
            $table->float('achievment_scale');
            $table->float('expected_achievement_scale');
            $table->float('gr_ALLGR_weight');
            $table->float('CO_GR_rest_weight')->default(1.00);
            $table->float('ccp_GR_rest_weight')->default(1.00);
            $table->primary('gr_code');
        });
        Schema::create('ALLGR_infos',function(Blueprint $table){
            $table->string('ALLGR_code', 64);
            $table->string('name', 64);
            $table->string('standart_description', 1024);
            $table->string('ise_description', 1024);
            $table->float('achievment_scale');
            $table->float('expected_achievement_scale');
            $table->float('gr_ALLGR_rest_weight')->default(1.00);
        });
        Schema::create('po_infos', function (Blueprint $table) {
            $table->string('po_code', 64);
            $table->string('name', 64);
            $table->string('standart_description', 1024);
            $table->string('ise_description', 1024);
            $table->float('achievment_scale');
            $table->float('expected_achievement_scale');

            $table->primary('po_code');
        });
        Schema::create('cm_infos', function (Blueprint $table) {
            $table->string('cm_code', 64);
            $table->string('course_code', 64);
            $table->string('name', 64);
            $table->string('EN_name',64);
            $table->string('description', 1024);
            $table->string('english_description', 1024);
            $table->primary('cm_code');
        });
        Schema::create('teach_plan',function (Blueprint $table){
            $table->string('course_code', 64);
            $table->string('cm', 64);
            $table->foreign('cm',64)->references('cm_code')->on('cm_infos');
            $table->integer('teach_hours');
            $table->string('teach_way',32);
            $table->text('teach_requirement');
            $table->text('teach_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_info');
        Schema::drop('gr_courses');
        Schema::drop('student_ccps');
        Schema::drop('ccp_infos');
        Schema::drop('cm_cos');
        Schema::drop('co_infos');
        Schema::drop('gr_infos');
        Schema::drop('po_infos');
        Schema::drop('cm_infos');
        Schema::drop('teach_plan');
    }
}
