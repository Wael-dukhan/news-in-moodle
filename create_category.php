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
//require_once($CFG->dirroot . '/local/greetings/lib.php');
require_once($CFG->dirroot . '/local/newsing/classes/form/category_form.php');
require_once($CFG->dirroot . "/local/newsing/classes/models/manager_category.php");


$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/newsing/create_category.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('pluginname', 'local_newsing'));

require_capability('local/newsing:postcategory', $context);


$categoryform = new local_news_category_form();        

if ($data = $categoryform->get_data()) {

    $category_name = required_param('namecategory', PARAM_TEXT);
    
    $parent_category = required_param('parent', PARAM_TEXT);
    if (!empty($category_name)) {
        $manager = new manager_category();
        // die("hhhhh");
        $manager->create_category($category_name,$parent_category);
    }
}

echo $OUTPUT->header();

$categoryform->display();
var_dump($category_name,!empty($parent_category)); 
echo "<hr>";
var_dump($data);
echo $OUTPUT->footer();
