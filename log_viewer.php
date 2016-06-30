<!doctype html> <html>
    <head>
        <meta charset="UTF-8">
        <title>Log Viewer</title>
        <style>
            .red {margin-left:10px;color:red;}
            .empty{margin-left:10px;}
            ul{list-style-type:circle;}
        </style>
    </head>
    <body>
        <h1>Welcome to the log viewer</h1>
        <?php
        // Size to check against //
        $size = 0;

        // Cycle through logs //
        foreach (new DirectoryIterator('logs') as $file) {

            // If not (.) or (..) //
            if (!$file->isDot()) {
                echo '&gt; <a href="log_viewer.php?view='
                . $file->getBasename() . '">' . ucfirst($file->getBasename('.txt')) . '</a>';

                // Displays new sign and last time modified or if file is empty //
                if ($file->getSize() > $size) {
                    echo '<span class="red">' . '&lt; New &gt;</span> '
                    . date("l, F d, Y g:ia", $file->getMTime());
                } else {
                    echo '<span class="empty">&lt; Empty &gt;</span>';
                }
                echo '<br>';
            }
        }

        // If view is set, displays log //
        if (isset($_GET['view'])) {

            // Path to log file //
            $log = 'logs' . DIRECTORY_SEPARATOR . $_GET['view'];
            // If the file path is good and file opens //

            if (file_exists($log) && is_readable($log) && $handle = fopen($log, 'r')) {

                // Name of log //
                echo '<h2>> ' . ucfirst(basename($log, '.txt')) . ' Log</h2>';

                // Display contents as list //
                echo '<ul>';

                // Get contents //
                while (!feof($handle)) {
                    $entry = fgets($handle);
                    if (trim($entry) != "") {
                        echo '<li>' . $entry . '</li>';
                    }
                }

                echo '</ul>';

                // Close handle //
                fclose($handle);
            } else {

                // Error file bad or could not be opened //
                echo '<br>';
                echo '<span class="red">Could not read from ' . basename($log) . '</span>';
            }
        }
        ?>
    </body>
</html>
