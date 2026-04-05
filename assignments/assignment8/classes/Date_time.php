<?php
require_once __DIR__ . '/Pdo_methods.php';

class Date_time {

    private $pdo;

    public function __construct() {
        $this->pdo = new PdoMethods();
    }

    public function checkSubmit() {
        if (isset($_POST['dateTime'])) {
            return $this->addNote();
        }
        if (isset($_POST['begDate'])) {
            return $this->getNotes();
        }
        return '';
    }

    private function addNote() {
        $dateTime = $_POST['dateTime'];
        $note     = trim($_POST['note']);

        if (empty($dateTime) || empty($note)) {
            return '<p class="text-danger">You must enter a date, time, and note.</p>';
        }

        $timestamp = strtotime($dateTime);

        $sql = "INSERT INTO note (date_time, note) VALUES (:date_time, :note)";

        $bindings = [
            [':date_time', $timestamp, 'int'],
            [':note',      $note,      'str']
        ];

        $result = $this->pdo->otherBinded($sql, $bindings);

        if ($result === 'error') {
            return '<p class="text-danger">There was an error saving your note.</p>';
        }

        return '<p class="text-success">Note added successfully.</p>';
    }

    private function getNotes() {
        $begDate = $_POST['begDate'];
        $endDate = $_POST['endDate'];

        if (empty($begDate) || empty($endDate)) {
            return '<p class="text-danger">No notes found for the date range selected.</p>';
        }

        // Convert the date into strings for timestamps
        $begTimestamp = strtotime($begDate);
        $endTimestamp = strtotime($endDate . ' 23:59:59');

        $sql = "SELECT date_time, note FROM note 
                WHERE date_time BETWEEN :begDate AND :endDate 
                ORDER BY date_time DESC";

        $bindings = [
            [':begDate', $begTimestamp, 'int'],
            [':endDate', $endTimestamp, 'int']
        ];

        $results = $this->pdo->selectBinded($sql, $bindings);

        if ($results === 'error' || empty($results)) {
            return '<p class="text-danger">No notes found for the date range selected.</p>';
        }

        $output  = '<table class="table table-bordered table-striped">';
        $output .= '<thead>
                        <tr>
                            <th>Date and Time</th>
                            <th>Note</th>
                        </tr>
                    </thead>';
        $output .= '<tbody>';

        //Converts back into readable state
        foreach ($results as $row) {

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