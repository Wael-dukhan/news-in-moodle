<?php
// يعالج هذا الملف مصادقة المستخدمين ، والتحقق من صحة الطلبات ،
// web service واسترجاع ومعالجة البيانات المطلوبة بواسطة ال
//Moodle  للتطبيقات أو الأنظمة الأخرى للتفاعل مع  API يوفر
//  والوصول إلى بياناته ووظائفه عن بُعد

// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_newsing
 * @copyright   2023 wael <wael-dukhan@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//local_newsing_service_external class in externallib.php
defined('MOODLE_INTERNAL') || die();
$functions= array(
    'local_newsing_get_news'=>array(
        'classname'=>'local_newsing_service_external',
        'methodname'=>'get_news',
        'classpath'=>'local/newsing/externallib.php',
        'description'=>'get news',
        'type'=>'read',
        'ajax'=>true,
        'capabilities'=>'',

    ),
    'local_newsing_get_categories'=>array(
        'classname'=>'local_newsing_service_external',
        'methodname'=>'get_category',
        'classpath'=>'local/newsing/externallib.php',
        'description'=>'get category',
        'type'=>'read',
        'ajax'=>true,
        'capabilities'=>'',
    )
);

$services=array(
    'news service'=>array(
        'functions'=>array(
            'local_newsing_get_news',
            'local_newsing_get_categories',
        ),
        'restrictedusers'=>0,
        'enabled'=>1,
        'shortname'=>'get_news_or_categories'
    )
);
// MoodleWSRestFormat :
    // - json: The response is returned in JSON format.
    // - xml: The response is returned in XML format.
    // - xmlrpc: The response is returned using XML-RPC protocol.
    // - php: The response is returned as a PHP array.
    // يجب تضمين هذه المعلمة في عنوان ال يو ار ال
    //  لطلب خدمة الويب لتحديد التنسيق المطلوب للاستجابة.
