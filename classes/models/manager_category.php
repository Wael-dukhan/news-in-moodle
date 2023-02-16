<?php
// This file is part of Moodle Course Rollover Plugin
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
 * @package     local_newsing
 * @author      wael
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


use dml_exception;
use stdClass;

class manager_category {

    /** Insert the data into our database table.
     * @param string $category_name
     * @return bool true if successful
     */
    public function create_category(string $category_name,string $parent_category): bool
    {  
        global $DB;
        $record = new stdClass;
        $record->name = $category_name;
        $record->parent = $parent_category;
        $record->time_created = time();
        
        try {
            $DB->insert_record('local_newsing_category', $record);
            // echo "yes";
            redirect("index.php");  
            return true;
        } catch (dml_exception $e) {
            return false;
        }
    }

}