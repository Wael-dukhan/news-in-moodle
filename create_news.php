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
require_once($CFG->dirroot . "/local/newsing/classes/form/news_form.php");
require_once($CFG->dirroot . "/local/newsing/classes/models/manager_news.php");

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/newsing/create_news.php'));
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('pluginname', 'local_newsing'));


$newsform = new local_news_news_form();
if ($data = $newsform->get_data()) {
    $titlenews = required_param('newstitle', PARAM_TEXT);
    $contentnews = required_param('newscontent', PARAM_TEXT);
    $selectedcategory = required_param('selectedcategory',     PARAM_TEXT);
    $imagecategory = optional_param('image', '', PARAM_TEXT);

    $file = $newsform->get_new_filename('image');
    // var_dump($file);//file name
    if ($file) {
        $fullpath = "upload/" . time() . $file;
        $success = $newsform->save_file('image', $fullpath, true);
        if (!$success) {
            echo "Oops! something went wrong!";
        }
    }
    else{
        $fullpath="";
    }
    $manager = new manager_news();
    $manager->create_news($titlenews, $contentnews, $selectedcategory, $fullpath);
}

echo $OUTPUT->header();

$newsform->display();
echo $OUTPUT->footer();
