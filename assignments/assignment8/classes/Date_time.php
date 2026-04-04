<?php
require_once 'Db_conn.php';
require_once 'Pdo_methods.php';

class Date_time {
    private $conn;
    private $pdo;

    public function __construct() {
        $db = new Db_conn();
        $this ->conn = $db->getConn(); 
        $this->pdo = new Pdo_methods();
    }

    //Called on both pages
    public function checkSubmit() {

    if(isset($_POST['dateTime'])) {
        return $this->addNote();
    }

    if(isset($_POST['begDate'])) {
        return $this->getNotes();
    }
    
        return ''; //Page loads up
    }


    //Add note function
    private function addNote() {

        $dateTime = $_POST['dateTime'];
        $note = trim($_POST['note']);

        if(empty($dateTime) || empty($note)) {
            return '<p class="text-danger">You must enter a date, time and a note.</p>';
        }

        //Convert dateTime to string
        $timeStamp = strtotime($dateTime);

        $sql = "INSERT INTO note (date_time, note) VALUES (:date_time, :note)";
        $params = [':date_time' => $timeStamp, ':note' => $note];

        $this->pdo->insert($this->conn, $sql, $params);

        return '<p class="text-success">Note added successfully.</p>';
    }

    
    //Handles displaying our notes
    private function getNotes() {

        $begDate = $_POST['begDate'];
        $endDate = $_POST['endDate'];


        if(empty($begDate) || empty($endDate)) {
            return '<p class="text-danger">No notes found for the date range selected.</p>';
        }

        // Convert the date-only strings to timestamps.
        // begDate starts at midnight (00:00:00) automatically.
        // endDate gets 23:59:59 so the full ending day is included.
        $begTimestamp = strtotime($begDate);
        $endTimestamp = strtotime($endDate . ' 23:59:59');

        $sql = "SELECT date_time, note FROM note
                WHERE date_time BETWEEN :begDate AND :endDate
                ORDER BY date_time DESC";

        $params = [':begDate' => $begTimestamp, ':endDate' => $endTimestamp];

        $results = this->pdo->select($this->conn, $sql, $params);


         if (empty($results)) {
            return '<p class="text-danger">No notes found for the date range selected.</p>';
        }


         // Build the HTML table
        $output  = '<table class="table table-bordered table-striped">';
        $output .= '<thead>
                        <tr>
                            <th>Date and Time</th>
                            <th>Note</th>
                        </tr>
                    </thead>';
        $output .= '<tbody>';


        foreach($results as $row) {

            //Converts our timestamp back to something we can read
            $formatted = date('n/d/Y h:i a', $row['date_time']);

            $output .= '<tr>';
            $output .= '<td>' . $formatted . '</td>';
            $output .= '<td>' . htmlspecialchars($row['note']) . '</td>';
            $output .= '</tr>';
        }

        $output .= '</tbody></table>';

        return $output;
    }
}