<?php

abstract class AbstractTaskManager {
    abstract public function addTask(string $task);

    abstract public function delTask(int $id);

    abstract public function getAllTasks();

    abstract public function updateTask(int $id, int $status);
}

class TaskManager extends AbstractTaskManager {

    protected $_id;

    protected $_name;

    // protected $_dbh;

    protected $_status;

    private $database;

    public function __construct() {
        $this->database = new DataBase;
    }

    public function setId(int $id) {
        if (is_int($id) && $id > 0) {
            $this->_id = $id;
        }   
    }

    public function getId() {
        return $this->_id;
    }

    public function setName(string $name) {
        if (is_string($name) && strlen($name) > 0) {
            $this->_name = $name;
        }
    }

    public function getName() {
        return $this->_name;
    }

    public function setStatus(int $status) {
        if (is_int($status) && $status >= 0) {
            $this->_status = $status;
        }
    }

    public function getStatus() {
        //error_log(print_r($this->_status, 1));
        return $this->_status;
        
    }

    public function addTask(string $_name) {

        if(isset($_name)) {
            $ajouterTask = "INSERT INTO todo (tache) VALUES (:name)";
            $stmta = $this->database->prepare($ajouterTask);
            $stmta->bindParam(':name', $_name, PDO::PARAM_STR);
            $stmta->execute();
            
            if($stmta->rowCount() > 0) {
                echo "<script>alert('tache ajoutée')</script>";
            }
        }  
    }

    public function getAllTasks() {
        $showTasks = "SELECT * FROM todo";
        $query = $this->database->prepare($showTasks);
        $query->execute();
        $arrResult = $query->fetchAll(PDO::FETCH_OBJ);
//error_log(print_r( $arrResult, 1));
        $arrTasks = [];
        foreach ($arrResult as $element) {
            $obj = new TaskManager();
            $obj->setId($element->id);
            $obj->setName($element->tache);
            $obj->setStatus($element->Status);
            $arrTasks[] = $obj;
        }
        return $arrTasks;
    }

    public function delTask(int $id) {
        $deleteTask = "DELETE FROM todo WHERE id=:id";
        $stmts = $this->database->prepare($deleteTask);
        $stmts->bindParam(':id', $id, PDO::PARAM_INT);
        $stmts->execute();
    }

    public function updateTask(int $id, int $status) {
        if ($status == 0){
            $status = 1;
        } else {
            $status = 0;
        }
        
        error_log($id. " ".$status);

        $changeStatus = "UPDATE todo SET Status=:status WHERE id=:id";
        $stmtc = $this->database->prepare($changeStatus);
        $stmtc->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtc->bindParam(':status', $status, PDO::PARAM_INT);
        if($stmtc->execute()) {
            error_log("Status changé");
        } else {
            error_log("failed");
        }
       
    }
}

?>