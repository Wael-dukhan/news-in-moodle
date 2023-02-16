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

class manager_news {

    /** Insert the data into our database table.
     * @param string $titlenews
     * @param string $contentnews
     * @param string $category_id
     * @param string $image

     * @return bool true if successful
     */
    public function create_news(string $titlenews, string $contentnews,string $selectedcategory,string $fullpath): bool
    {  
        global $DB;

        $record = new stdClass;
        $record->title = $titlenews;
        $record->content = $contentnews;
        $record->category_id =$selectedcategory;
        $record->image=$fullpath;
        $record->time_created = time();
      
        try {
            $DB->insert_record('local_newsing', $record);  
            redirect("index.php",\core\output\notification::NOTIFY_SUCCESS . "  created news");
            return true;
        } catch (dml_exception $e) {
            return false;
        }
    }

    
        // Users without permission should only delete their own post.
        // TODO: Confirm before deleting.
    /** Insert the data into our database table.
     * @param string $titlenews
     * @param string $contentnews
     * @param string $category_id
     * @param string $image

     * @return bool true if successful
     */
    public function delete_news($params): bool
    {  
        try{
        global $DB,$PAGE;
        // die("fffff");

        $DB->delete_records('local_newsing', $params);
        redirect($PAGE->url);
        return true;
        }
        catch (dml_exception $e) {
            return false;
        }
    }
}