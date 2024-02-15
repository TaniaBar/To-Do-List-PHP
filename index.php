<?php 
// error_log("start");
function chargerClasse($classe) {
    require $classe . '.class.php';
}

spl_autoload_register('chargerClasse');

$database = new DataBase();

$taskManager = new TaskManager();


$taskManager->getAllTasks();
$tasks = $taskManager->getAllTasks();
//error_log("voici: " . print_r($tasks, 1));

if(isset($_POST['add'])) {
    $taskManager->addTask($_POST['name']);

    header('location: index.php');
}

if(isset($_GET['del_task'])) {

    $id = $_GET['del_task'];
    $taskManager->delTask($id);

    header('location: index.php');
}

error_log(print_r($_GET, 1));

if(isset($_GET['doneTask']) && isset($_GET['stat'])) {
    error_log("GET :".print_r($_GET['doneTask'], 1));
    $id = $_GET['doneTask'];
    $status = $_GET['stat'];
    error_log("Status : ".print_r($status));
    $taskManager->updateTask($id, $status);

    header('location: index.php');
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>ToDoList2</title>
    
</head>
<body style="background-color: #eee;">
    <section >
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card rounded-3">
                        <div class="card-body p-4">
                            <h3 class="text-center my-3 pb-3">To do List POO</h3>

                            <form action="index.php" method="post" class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                                <div class="col-12">
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="name" placeholder="entre your task">
                                        <label for="form1" class="form-label"></label>
                                    </div>
                                </div>

                                <div class="col-12 d-grid gap-2 d-flex justify-content-center" >
                                    <button type="submit" class="btn btn-primary" name="add">Add</button>
                                </div>
                            </form>

                            <table class="table mb-4">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">To do</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 0;
                                    
                                    $style= '';
                                    if (!empty($tasks)) {
                                        foreach($tasks as $task) {  
                                            // error_log("tache ".print_r($task, 1)); 
                                            // error_log("id ".print_r($task->getId(), 1)); 
                                            // error_log("st ".print_r($task->getStatus(), 1)); 
                                            $i++;
                                        if($task->getStatus() == 1) {
                                            $style = "text-decoration: line-through";
                                        } else {
                                            $style = "text-decoration: none";
                                        }

                                    ?>
                                    <tr>
                                        <td name="count"><?php echo $i ?></td>
                                        <td name="nameTask" id="nameTask" style="<?php echo $style?>"><?php echo htmlentities($task->getName());?></td>
                                        
                                        <td>
                                            <a href="index.php?doneTask=<?php echo htmlentities($task->getId());?>&stat=<?php echo htmlentities($task->getStatus());?>">
                                                <button type="submit" class="btn btn-success ms-1" name="doneTask">Done</button>
                                            </a>

                                            <a href="index.php?del_task=<?php echo $task->getId();?>" onclick="return confirm('Are you sure?')">
                                                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php        
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        // const finishButtons = document.querySelectorAll('.finishTask');

        // finishButtons.forEach(button => {
        //     button.addEventListener('click', function() {
                // const parentRow = this.closest('tr');
        //         const nameTask = parentRow.querySelector('#nameTask');
        //         nameTask.style.textDecoration = "line-through";
        //         this.style.opacity = "0.5";
        //         this.disable = "true";
        //         // saveTask();   
        //     })
        // })

        // function saveTask() {
        //     localStorage.setItem('task', listContainer.innerHTML);
        // }

        // function showTask() {
        //     listContainer.innerHTML = localStorage.getItem('task');
        // }
        // showTask();

    </script>
</body>
</html>