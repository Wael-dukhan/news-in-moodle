
<?php
// يحتوي على الوظائف  والفئات الأساسية اللازمة لتنفيذ خدمة الويب
// externallib.php يمكن للمطورين استخدام الوظائف والفئات المحددة في ملف 
//Moodle لبناء تطبيقاتهم الخاصة التي يمكنها التفاعل برمجيًا مع .
// هذا الملف هو جزء أساسي من البنية التحتية لخدمة ويب موودل
//  ويساعد على توفير وصول آمن وفعال لموارد موودل للتطبيقات الخارجية.

// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * ${PLUGINNAME} file description here.
 *
 * @package    ${PLUGINNAME}
 * @copyright  2023 Islam <${USEREMAIL}>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// use core_completion\progress;
global $CFG ;
require_once($CFG->dirroot.'/config.php');
require_once($CFG->libdir.'/externallib.php');
/**
*
* core class هي فئة أساسية في  : Externalapi class
* Moodle's Web Services API التي توفر واجهة قياسية لإنشاء خدمات ويب مخصصة
* يحدد طرق تسجيل خدمات الويب وإدارتها والمصادقة عليها 
* ، فضلاً عن التحكم في الوصول إلى وظائف وبيانات محددة.
* يسمح بالتكامل والتوافق  للتطبيقات الخارجية مع بيانات وخدمات موودل.
*/

class local_newsing_service_external extends external_api{
    public static function get_news($categoryid = '')
    {
        global $DB;
        if($categoryid=='')
        {
            $records=$DB->get_records('local_newsing');
            return $records;
        }
        else{
            $params['category_id']=$categoryid;
            $records=$DB->get_records('local_newsing', $params);
            return $records;
        }
    }
     /**  It is used to define the input parameters for an external function call in Moodle
        * تساعد هذه الفئة في تحديد نوع البيانات والقيمة الافتراضية 
        * والقيودالخاصة ببرامترات الإدخال التي يجب تمريرها إلى الوظيفة خارجية
        * و تقليل مخاطر الأخطاء وتحسين الموثوقية الشاملة لخدمات الويب الخاصة بهم 
    */
    public static function get_news_parameters()
    {
        /**
            *Moodle Web Service يستخدم بشكل شائع لإرجاع القيم من  وظائف 
            *Moodle إلى external system requests  أو في لإرجاع بارامترات من نظام خارجي  .
        */
        return new external_function_parameters( array(
            'category_id'=>new external_value(PARAM_TEXT,'category_id',VALUE_OPTIONAL)
        ),
        );
    }

      /**  activities  اأولأنشطةresources  يستخدم هذا الكلاس عادةً لإرجاع قائمة  بالموارد  
        *  أو وحدات الدورة التدريبية أو المستخدمين ، 
        *  أو كائنات البيانات الأخرى من قاعدة بيانات موودل.
        *  other Moodle web service classes  تُستخدم مع 
        *  such as the external_single_structure class and the external_description class,
        *  لإنشاء هياكل وأنواع بيانات أكثر تعقيدًا.
        */
    public static function get_news_returns()
    {
        return new external_multiple_structure(
             new external_single_structure(
            array(
                'Id_of_Moodle_Web_Service_functions'=>new external_value(PARAM_TEXT,'id'),
                'Title_of_Moodle_Web_Service_functions'=>new external_value(PARAM_TEXT,'title'),
                'Content_of_Moodle_Web_Service_functions'=>new external_value(PARAM_TEXT,'content'),
                'Category_ID_of_Moodle_Web_Service_functions'=>new external_value(PARAM_TEXT,'category_id'),
                'Time_created_of_Moodle_Web_Service_functions'=>new external_value(PARAM_TEXT,'time_created'),
                'Image_url_of_Moodle_Web_Service_functions'=>new external_value(PARAM_TEXT,'image url'),
            ),
        ));
    }
    public static function get_category()  
    {
        global $DB;
        $records=$DB->get_records('local_newsing_category');
        return $records;
    }
    /**  It is used to define the input parameters for an external function call in Moodle
        * تساعد هذه الفئة في تحديد نوع البيانات والقيمة الافتراضية 
        * والقيودالخاصة ببرامترات الإدخال التي يجب تمريرها إلى الوظيفة خارجية
        * و تقليل مخاطر الأخطاء وتحسين الموثوقية الشاملة لخدمات الويب الخاصة بهم 
    */
    public static function get_category_parameters()
    {
        /**
            *Moodle Web Service يستخدم بشكل شائع لإرجاع القيم من  وظائف 
            *Moodle إلى external system requests  أو في لإرجاع بارامترات من نظام خارجي  .
        */
        return new external_function_parameters( array(
        ),
        );
    }

      /**  activities  اأولأنشطةresources  يستخدم هذا الكلاس عادةً لإرجاع قائمة  بالموارد  
        *  أو وحدات الدورة التدريبية أو المستخدمين ، 
        *  أو كائنات البيانات الأخرى من قاعدة بيانات موودل.
        *  other Moodle web service classes  تُستخدم مع 
        *  such as the external_single_structure class and the external_description class,
        *  لإنشاء هياكل وأنواع بيانات أكثر تعقيدًا.
        */
        public static function get_category_returns()
        {
            return new external_multiple_structure(
                 new external_single_structure(
                array(
                    'id'=>new external_value(PARAM_TEXT,'id'),
                    'parent'=>new external_value(PARAM_TEXT,'parent'),
                    'name'=>new external_value(PARAM_TEXT,'name'),
                    'time_created'=>new external_value(PARAM_TEXT,'time_created'),
                ),
            ));
        }
}
