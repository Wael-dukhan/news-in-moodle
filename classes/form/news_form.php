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
defined('MOODLE_INTERNAL') || die();
global $CFG;

require_once($CFG->libdir . '/formslib.php');

class local_news_form extends moodleform {
    /**
     * Define the form.
     */

    public function definition() {
        $mform    = $this->_form; // Don't forget the underscore!

        global $DB,$CFG;
        $mform->addElement('textarea', 'newstitle', get_string('newstitle_form', 'local_news')); // Add elements to your form.
        $mform->setType('newstitle', PARAM_TEXT); // Set type of element.
        $mform->addElement('textarea', 'newscontent', get_string('newscontent_form', 'local_news'),array('rows'=>10,'col'=>100)); // Add elements to your form.
        $mform->setType('newscontent', PARAM_TEXT); // Set type of element.

        $mform->addElement("hidden",'id');
        $records=$DB->get_records('local_newsing_category');
        $categories=array();


        foreach($records as $record)
        {
            $categories[$record->id]=$record->name;
        }
        $mform->addElement('select', 'selectedcategory','dropdown',$categories); // Add elements to your form.
//        ----------------------------------
        // Set type of element.
        $mform->addElement('filepicker', 'image', get_string('file'), null,
            array('maxbytes' => 11111111111111, 'accepted_types' => '*'));
        // $mform->setDefault('image',$CFG->wwwroot.'/local/newsing/upload/1676043809image2.jpg');
            // https://source.unsplash.com/random?u={{ $product->id }}"

        $submitlabel = get_string('submit');
        $mform->addElement('submit', 'submitmessage', $submitlabel);

    }
    public function getMyObject(){
        return $this->_form;

    }
}
