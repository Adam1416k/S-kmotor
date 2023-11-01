<?php
    //Kolla sökbegäran
    if (isset($_POST['directory']) && !empty($_POST['directory'])) {
        $baseDirectory = "C:/Users/adama/Documents/";
        $directoryName = $_POST['directory'];
    
        //hitta fulla sökvägen
        $foundDirectoryPath = searchDirectory($baseDirectory, $directoryName);
    
        //om mappen finns
        if ($foundDirectoryPath) {
            //gå igenom alla filer
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($foundDirectoryPath));
    
            $largestFile = null;
            $largestFileSize = 0;
    
            //Iterera genom filerna i mappen
            foreach ($files as $file) {
                //gemför storleken på filerna
                if ($file->isFile() && $file->getSize() > $largestFileSize) {
                    $largestFileSize = $file->getSize();
                    $largestFile = $file->getPathname();
                }
            }
    
            //Visa den största filen
            if ($largestFile) {
                echo "<h3>Den största filen i mappen '" . htmlspecialchars($directoryName) . "':</h3>";
                echo "<p>Filnamn: " . htmlspecialchars(basename($largestFile)) . "</p>";
                echo "<p>Storlek: " . formatBytesToMB($largestFileSize) . " MB</p>";
            } else {
                echo "Inga filer hittades i den angivna mappen.";
            }
        } else {
            echo "Ingen mapp med det namnet hittades.";
        }
    }
    
    //Konvertera bytes till mb
    function formatBytesToMB($bytes, $precision = 2) {
        return round($bytes / (1024 * 1024), $precision);
    }
    
    //Söka efter mappar inom både mappar och basmappar
    function searchDirectory($basePath, $dirName) {
        //Gå igenom alla mappar i en basmappen
        $directories = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath), RecursiveIteratorIterator::SELF_FIRST);
    
        //Iterera alla mappar
        foreach ($directories as $directory) {
            if ($directory->isDir() && $directory->getFilename() === $dirName) {
                return $directory->getPathname();
            }
        }
    
        return false;
    }        
?>