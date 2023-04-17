<?php
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
 * Main file to view greetings
 *
 * @package     local_newsing
 * @copyright   2022 Your name <your@email>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once('../../config.php');
require_once($CFG->dirroot . "/local/newsing/classes/models/manager_news.php");
$PAGE->requires->css('/local/newsing/styles.css');

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/newsing/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('head_list_news', 'local_newsing'));

require_login();

if (isguestuser()) {
    throw new moodle_exception('no guest');
}

$allowpost     = has_capability('local/newsing:viewnews', $context);
$deletepost    = has_capability('local/newsing:deleteownnews', $context);
$deleteanypost = has_capability('local/newsing:deleteanynews', $context);
$updateownpost = has_capability('local/newsing:poatownnews', $context);
$updateanypost = has_capability('local/newsing:postanynews', $context);


$sql = "SELECT m.id, m.title,m.content,m.image, m.time_created, m.category_id, u.name
              FROM {local_newsing} m  LEFT JOIN {local_newsing_category} u 
              ON u.id = m.category_id ORDER BY time_created DESC";

$news = $DB->get_records_sql($sql);
$action = optional_param('action', '', PARAM_TEXT);
if ($action == 'del') {
    require_sesskey();

    $id = required_param('id', PARAM_TEXT);
    $params = array('id' => $id);
    $manager = new manager_news();
    $manager->delete_news($params);
}
$template=[
    'title' => 'Mustache links',
    'links' => [
      ['href' => 'https://mustache.github.io'],
      ['href' => 'https://github.com/mustache/spec', 'title' => 'The Mustache spec'],
      ['href' => 'https://github.com/bobthecow/mustache.php', 'title' => 'Mustache.php'],
    ]
    ];
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_newsing/test', $template);

if ($allowpost) {
    
    echo html_writer::start_div("row", null);

    echo html_writer::link(new moodle_url('/local/newsing/create_category.php'), 'Create Category', array('class' => 'btn btn-primary a col-5 mx-5 mb-3'));

    echo html_writer::link(new moodle_url('/local/newsing/create_news.php'), 'Create News', array('class' => 'btn btn-primary a col-5 mx-5 mb-3'));

    echo html_writer::end_div();
    // echo '<img src="../../local/newsing/upload//1676552306image3.jpg">';

    echo html_writer::start_tag('div', array('class' => 'row'));

    foreach ($news as $m) {
        echo html_writer::start_div('col-4 ', null);
        echo html_writer::start_tag('div', array('class' => 'card mb-2 bg-gray'));
        echo html_writer::start_tag('div', array('class' => 'card-body'));//upload/1676131964image2.jpg
        $img = html_writer::empty_tag('img', array('src' => (bool)$m->image ? $m->image : '', 'class' => 'img-thumbnail img', 'alt' => "Alt text for your image "));
        echo html_writer::tag('p', $img,['class'=>'img']);
        echo html_writer::tag('p', format_text($m->title, FORMAT_PLAIN), array('class' => 'card-text'));
        echo html_writer::tag('p', format_text($m->name , FORMAT_PLAIN), array('class' => 'card-text'));
        echo html_writer::start_tag('p', array('class' => 'card-text'));
        echo html_writer::tag('small', format_text($m->content, FORMAT_PLAIN), array('class' => 'text-black-200'));
        echo html_writer::end_tag('p');
        echo html_writer::start_tag('p', array('class' => 'card-text'));
        echo html_writer::tag('small', userdate($m->time_created), array('class' => 'text-info '));
        echo html_writer::end_tag('p');
        echo html_writer::start_tag('p', array('class' => 'card-text'));
        echo html_writer::tag('small', format_text($m->category_id, FORMAT_PLAIN), array('class' => 'text-muted '));
        echo html_writer::end_tag('p');
        if ($deleteanypost || $deletepost) {
            echo html_writer::start_tag('p', array('class' => 'card-footer text-center'));
            echo html_writer::link(
                new moodle_url(
                    '/local/newsing/index.php',
                    array('action' => 'del', 'id' => $m->id, 'sesskey' => sesskey())
                ),
                $OUTPUT->pix_icon('t/delete', '') . get_string('delete')
            );

            echo html_writer::end_tag('p');
        }
        if ($updateownpost || $updateanypost) {

            echo html_writer::start_tag('p', array('class' => 'card-footer text-center'));

            echo html_writer::link(
                new moodle_url(
                    '/local/newsing/edit_news.php',
                    array('action' => 'edit', 'id' => $m->id, 'title' => $m->title, 'content' => $m->content,'image'=>$m->image, 'category_id' => $m->category_id, 'name' => $m->name, 'sesskey' => sesskey())
                ),
                $OUTPUT->pix_icon('t/edit', '') . "Edit",array("aria-label"=>"edit news")
            );

            echo html_writer::end_tag('p');
        }
        echo html_writer::end_tag('div');
        echo html_writer::end_tag('div');
        echo html_writer::end_div();
        // var_dump((bool)$m->image);
    }

    echo html_writer::end_tag('div');
}
    // var_dump($ADMIN->fulltree);
echo $OUTPUT->footer();
