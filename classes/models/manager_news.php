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
/** Get the last five news
*   @return array of last five news
*/ 
public function get_num_news()
{
        global $DB;

        $sql = "SELECT ln.id, ln.title, ln.content  , ln.image
            FROM {local_newsing} ln
            LEFT OUTER JOIN {local_newsing_category} lnc ON lnc.id = ln.category_id
            ORDER BY id DESC
            LIMIT 5";
        try {
            return $DB->get_records_sql($sql);
        } catch (dml_exception $e) {
            // Log error here.
            return $DB->get_records('local_newsing') ;
        }
    }
        
    /** It gives the news of the filter according to the category 
    *   @param int $filter
    *   @return array of news
    */ 
    public function get_news_filter($filter){
        global $DB;
        $sql='SELECT ln.id, ln.title, ln.content, ln.image, ln.category_id, ln.time_created
            FROM {local_newsing} ln
            LEFT OUTER JOIN {local_newsing_category} lnc ON lnc.id = ln.category_id
            WHERE ln.category_id = :filterid';
        $params=[
            'filterid'=>$filter
        ];
        try {
            return $DB->get_records_sql($sql,$params);
        } catch (dml_exception $e) {
            // Log error here.
            return $DB->get_records('local_newsing') ;
        }
    }
    
    /** Get a single message from its id.
     * @param int $newsid the message we're trying to get.
     * @return object|false message data or false if not found.
     */
    public function get_news(int $newsid)
    {
        global $DB;
        return $DB->get_record('local_newsing', ['id' => $newsid]);
    }
    /** Get all news from its id.
     * @param int $newsid the message we're trying to get.
     * @return object|false message data or false if not found.
     */
    public function get_all_news(): array
    {
        global $DB;
        return $DB->get_records('local_newsing');
    }
}