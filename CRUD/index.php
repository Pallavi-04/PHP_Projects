<?php
  /**
   * Pallavi Shukla 
   * (C) Copyright-- <pallavi04pallavi@gmail.com>
   */

    $insert = false;
    $update = false;
    $delete = false;

    //Connecting to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notes";

    $conn = mysqli_connect( $servername, $username, $password, $database );

    if(!$conn)
      die("Sorry, we failed to connect due to error --> ".mysqli_connect_error());
 
    // exit();

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      //---------------------UPDATING the record -----------------------------------
        if( isset( $_POST['snoEdit'] ) ) { 
          $sno = $_POST["snoEdit"];
          $title = $_POST["titleEdit"];
          $description = $_POST["descriptionEdit"];

          $sql="UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`s_no` = $sno;";
          $result = mysqli_query($conn, $sql);

          if( $result )
            $update = true;
          else 
            echo "We couldn't update the record";
        } 
        //-------------------------- INSERTING the record ----------------------------------------
        else {

          $title = $_POST["title"];
          $descr = $_POST["description"];

          $sql="INSERT INTO `notes` ( `title`, `description`) VALUES ( '$title', '$descr');";
          $result = mysqli_query($conn, $sql);
      
          //Check for the table creation
          if($result)
                $insert = true;
              // echo "<br>Record has been inserted successfully.<br>";
          else 
              echo "Record was not inserted successfully because ".mysqli_error($conn);
        }
        
    }

    //--------------DELETING a record
    if( isset($_GET['delete']) ) {
      $sno = $_GET['delete'];
      $delete = true;

      $sql = "DELETE FROM `notes` WHERE `notes`.`s_no` = $sno;";
      $result = mysqli_query( $conn, $sql );
    }
    
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>iNotes- Notes taking made easy</title>
    <!-- Bootstrap css -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    
  </head>

  <body>

        <!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit this Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action= "/CRUD/index.php" method="post">
          <div class="modal-body">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input
                  type="text"
                  class="form-control"
                  id="titleEdit"
                  name="titleEdit"
                  aria-describedby="emailHelp"
                />
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <div class="form-floating">
                  <textarea
                    class="form-control"
                    placeholder="Leave a comment here"
                    id="descriptionEdit"
                    style="height: 100px"
                    name="descriptionEdit"
                  ></textarea>
                  <label for="floatingTextarea2"></label>
                </div>
              </div>
              <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
            </div>
            <div class="modal-footer d-block mr-auto">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
      </form>
    </div>
  </div>
</div>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="logo_php.png" alt="phpLogo" height="40px" ></a>
        <a class="navbar-brand" href="#">iNotes</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact Us</a>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </div>
      </div>
    </nav>

    <?php
      if($insert)
        echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been inserted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div><br>";

      if($update)
        echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div><br>";

      if($delete)
        echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div><br>";
    ?>

    <div class="container my-4">
      <h2>Add a Note to iNotes App</h2>
      <form action= "/CRUD/index.php" method="post">
        <div class="mb-3">
          <label for="title" class="form-label">Note Title</label>
          <input
            type="text"
            class="form-control"
            id="title"
            name="title"
            aria-describedby="emailHelp"
          />
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Note Description</label>
          <div class="form-floating">
            <textarea
              class="form-control"
              placeholder="Leave a comment here"
              id="description"
              style="height: 100px"
              name="description"
            ></textarea>
            <label for="floatingTextarea2"></label>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
    </div>

    <div class="container">
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">S.No.</th>
              <th scope="col">Title</th>
              <th scope="col">Description</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php 
                  $sql = "SELECT * FROM `notes`;";
                  $result = mysqli_query($conn, $sql);
                  $sno = 0;
                  while($row = mysqli_fetch_assoc($result)) 
                  {
                    $sno+=1;
                    echo "<tr>
                    <th scope='row'>".$sno."</th>
                    <td>".$row["title"]."</td>
                    <td>".$row["description"]."</td>
                    <td><button class='edit btn btn-sm btn-primary'
                                id=".$row["s_no"].">Edit</button> <button class='delete btn btn-sm btn-primary' 
                                id=d".$row["s_no"].">Delete</button></td>
                    </tr>"; 
                  }
          ?>
          </tbody>
          
        </table>
    </div>

    <!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
      integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
      crossorigin="anonymous"
    ></script>

    <script>
      $(document).ready( function () {
                        $('#myTable').DataTable();
      });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach( (element) => {
      element.addEventListener("click", (e)=> {
        // console.log("edit");
        //Fetching title and description for delete element
        tr =  e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
      });
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach( (element) => {
      element.addEventListener("click", (e)=> {
        //Fetching title and description for delete element
       sno = e.target.id.substr(1, );
       
       //Confirm modal box prevents you or anyone from accidentally deleting the note
        if( confirm("Are you sure you want to delete this note?") ) {
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
          //Dirctly jumping to the above url can delete the note which is a SECURITY LOOPHOLE ( a malicious intent)
          //TODO: Create a form and use post request to submit the form
        }
        else
          console.log("no");
      });
    })
  </script>
  </body>
</html>
 