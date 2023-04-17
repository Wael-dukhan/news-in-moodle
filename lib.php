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
 * Library of functions for local_newsing
 *
 * @package     local_newsing
 * @copyright   2023 wael <wael1141998@email>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();


/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
function local_newsing_extend_navigation_frontpage(navigation_node $frontpage) {
    global $OUTPUT;

    $frontpage->add(
        $OUTPUT->pix_icon('t/message', '') . get_string('pluginname', 'local_newsing'),
        new moodle_url('/local/newsing/index.php'),
        navigation_node::TYPE_CUSTOM,
        null,
        null,
        new pix_icon('t/message', '')
        // null
    );
}

//  pix_icon('t/message', 'Send a message');
//  pix_icon('t/edit', 'Edit this item');
//  pix_icon('t/delete', 'Delete this item');
//  pix_icon('t/add', 'Add a new item');
//  pix_icon('t/copy', 'Copy this item');
//  pix_icon('t/lock', 'Lock this item');
//  pix_icon('t/unlock', 'Unlock this item');
//  pix_icon('t/preview', 'Preview this item');
//  pix_icon('t/check', 'Check this item');
//  pix_icon('t/go', 'Go to this item');

/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
// function local_newsing_extend_navigation(global_navigation $root)
// {
//     $node = navigation_node::create(
//         get_string('pluginname', 'local_newsing'),
//         new moodle_url('/local/newsing/index.php')
//     );

//     $node->showinflatnavigation = true;
//     $root->add_node($node);
// }
?>