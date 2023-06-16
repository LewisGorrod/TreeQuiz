<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>Tree Quiz</title>
    </head>
    <body>
        <h1>What's this tree?</h1>
        <?php
            $tree_folders = glob('images/*');
            // if the user hasn't just submitted an answer, generate a new question
            if (!isset($_POST['submit'])) {
                $tree_folder = $tree_folders[array_rand($tree_folders)];
                $tree_image = glob($tree_folder . '/*')[array_rand(glob($tree_folder . '/*'))];
                $tree_type = str_replace('images/', '', $tree_folder);
            } else { // else get the current question data (tree type and image)
                $tree_image = $_POST['tree_image'];
                $tree_type = $_POST['tree_type'];
            }
            echo '<img src="' . $tree_image . '" height=400>';
        ?>
        <form action="index.php" method="POST">
            <br>
            <?php
                // submit question data so that it 'remembers' the question after the form is first submitted 
                echo '<input type="hidden" name="tree_image" value="' . $tree_image . '">';
                echo '<input type="hidden" name="tree_type" value="' . $tree_type . '">';
                // list all available options
                $first_option = str_replace('images/', '', $tree_folders[0]);
                foreach ($tree_folders as $tree_folder) {
                    $tree_type_option = str_replace('images/', '', $tree_folder);
                    // keep selected answer as checked after user makes a guess OR select first option by default if a new question
                    $checked = '';
                    if (isset($_POST['selected_tree_type']) && isset($_POST['submit'])) {
                        if (strcmp($_POST['selected_tree_type'], $tree_type_option) == 0) {
                            $checked = ' checked="True"';
                        }
                    } elseif (strcmp($tree_type_option, $first_option) == 0) {
                        $checked = ' checked="True"';
                    }
                    echo '<input type="radio" name="selected_tree_type" value="' . $tree_type_option . '"' . $checked . '>';
                    echo '<label for="' . $tree_type_option . '">' . $tree_type_option . '</label>';
                }
                echo '<br><br>';
                // if user hasn't just submitted an answer, provide the submit button
                if (!isset($_POST['submit'])) {
                    echo '<input type="submit" name="submit" value="Submit">';
                } else { // else let the user know if they were right or wrong
                    if (strcmp($_POST['selected_tree_type'], $tree_type) == 0) {
                        echo 'Correct!';
                    } else {
                        echo 'Wrong! It\'s a(n) ' . $tree_type . ' tree.';
                    }
                    // and provide the next question button instead
                    echo '<br><br><input type="submit" name="next" value="Next">';
                }
            ?>
        </form>
    </body>
</html>