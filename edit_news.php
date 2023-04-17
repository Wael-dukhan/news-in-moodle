<?php
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
 * @copyright  2022 Your name <your@email>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once('../../config.php');
require_once($CFG->dirroot . '/local/newsing/classes/form/news_form.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/newsing/create_news.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('pluginname', 'local_newsing'));
// $action= optional_param('action','', PARAM_TEXT);


    $idnews = required_param('id', PARAM_INT);
    $image = optional_param('image', "",PARAM_TEXT);
    $titlenews = optional_param('title', '', PARAM_TEXT);
    $contentnews = optional_param('content', '', PARAM_TEXT);
    $selectedcategory = optional_param('category_id', '', PARAM_TEXT);

    $classform = new local_news_news_form();
    $classform->getMyObject()->setDefault('image', $image);
    $classform->getMyObject()->setDefault('newstitle', $titlenews);
    $classform->getMyObject()->setDefault('newscontent', $contentnews);
    $classform->getMyObject()->setDefault('selectedcategory', $selectedcategory);
    $classform->getMyObject()->setDefault('id', $idnews);

    if ($data = $classform->get_data()) {
        //    $idnews = required_param('id', PARAM_INT);
        $imagenews1 = required_param('image', PARAM_TEXT);
        $titlenews1 = required_param('newstitle', PARAM_TEXT);
        $contentnews1 = required_param('newscontent', PARAM_TEXT);
        $selectedcategory1 = required_param('selectedcategory', PARAM_TEXT);
        $id = required_param('id', PARAM_TEXT);
        $file = $classform->get_new_filename('image');

        $fullpath = "upload/". time().$file;
        $params['id'] = $idnews;
        $where = 'WHERE id = :id';
        $record = $DB->get_record_sql("SELECT image FROM {local_newsing} $where", $params);
        if (file_exists($record->image)) {
            unlink($record->image);

        }
        $success = $classform->save_file('image', $fullpath,true);
    
    
        if(!$success){
            echo "Oops! something went wrong!";
        }
        if (!empty($imagenews1) && !empty($titlenews1) && !empty($contentnews1) && !empty($selectedcategory1)) {
            $record = new stdClass;
            $record->id = $idnews;
            $record->title = $titlenews1;
            $record->content = $contentnews1;
            $record->categoryid = $selectedcategory1;
            $record->image = 'upload/'.time().$file;

            $record->timecreated = time();

            $DB->update_record('local_newsing', $record);
            redirect("http://localhost/moodle/local/newsing/index.php","Updated complete");
        }
    }

echo $OUTPUT->header();
$classform->display();

//print($idnews);
//print( $classform->get_data());
// echo $idnews;
// echo $titlenews;
echo $OUTPUT->footer();
