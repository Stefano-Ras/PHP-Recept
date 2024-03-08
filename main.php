<html>
    <body style="width:75%;margin-top:25px;margin-bottom:25px;margin-left:auto;margin-right:auto;">
        <div>
            <form action="" method="post">
                <?php
                    include("connect.php");
                    
    
                    $conn = new mysqli("localhost", "root", "", "recipe");
                    if ($conn->connect_error) {
                        # Display an error mesage if the connection fails
                        die("Connection failed: " . $conn->connect_error);
                    }
                /* 
                    $region = $conn->prepare("SELECT * FROM region");
                    $region = $conn->prepare("INSERT INTO region (Name, Description) VALUES (?, ?, ?)");
                    $region->bind_param("userregion", $Name, $Description);

                    file_put_contents("./recipe.json", json_encode($region));
                */
                    //SELECT * FROM region WHERE Name = filtered name
                    $regionResult = $db("SELECT DISTINCT Region FROM Recipe ORDER BY Name ASC");
                    //$sql = "SELECT * FROM region;";
                    ?>
                    <div class="search-box">
                        <select id="region" name="region[]">
                            <option value="0" selected="selected">Select region</option>
                            <?php
                                if (! empty($regionResult)) {
                                     foreach ($regionResult as $key => $value) {
                                         echo '<option value="' . $regionResult[$key]['Region'] . '">' . $regionResult[$key]['Region'] . '</option>';
                                     }
                                 }
                            ?>
                        </select>
                        <button id="filter">Search</button>
                    </div>
                <?php
                    $sql = "SELECT * FROM region;";
                    $result = $conn->query($sql);
                    $resultCheck = mysqli_num_rows($result);
                    if($resultCheck > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo $row['Name'] . "<br>" . $row['Description'] . "<br><br>";
                        }
                    }

                    $sqlIngredients = "SELECT * FROM ingredients;";
                    $resultIngredients = mysqli_query($conn, $sqlIngredients);
                    $resultCheckIngredients = mysqli_num_rows($resultIngredients);
                    if($resultCheckIngredients > 0) {
                        while($row = mysqli_fetch_assoc($resultIngredients)) {
                            echo $row['Amount'] . " " . $row['Unit'] . " " . $row['Name'] . "<br><br>";
                        }
                    }

                    $sqlRecipe = "SELECT * FROM recipe;";
                    $resultRecipe = mysqli_query($conn, $sqlRecipe);
                    $resultCheckRecipe = mysqli_num_rows($resultRecipe);
                    if($resultCheckRecipe > 0) {
                        while($row = mysqli_fetch_assoc($resultRecipe)) {
                            echo $row['Name'] . "<br><br>" . $row['Description'] . "<br><br>" . $row['Life_Story'] . "<br><br>" . $row['Instructions'] . "<br><br>";
                        }
                    }

                    //Join recipe & ingredients tables
                    //Show Recipe Name, Description, Story / Ingredients Amount, Unit, Name

                ?>
            </form>
        </div>
    </body>
</html>
<?php
    $conn->close();
?>