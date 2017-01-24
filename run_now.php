<html>
    <body>
        
<?php

    if( !isset($_POST['code']) ) { echo shell_exec('echo ERROR: No code passed to run.php >> user_data/ERRORS/input_validation.log');}
    $code=$_POST["code"];
    if( !isset($_POST['kmer_length']) ) { echo shell_exec("echo ERROR: No kmer_length passed to run_now.php >> user_data/$code/input_validation.log");}
    if( !isset($_POST['read_length']) ) { echo shell_exec("echo ERROR: No read_length passed to run_now.php >> user_data/$code/input_validation.log");}
    if( !isset($_POST['max_kmer_cov']) ) { echo shell_exec("echo ERROR: No max_kmer_cov passed to run_now.php >> user_data/$code/input_validation.log");}
    if( !isset($_POST['description']) ) { echo shell_exec("echo ERROR: No description passed to run_now.php >> user_data/$code/input_validation.log");}

    echo shell_exec("echo user_data/$code/input_validation.log >> user_data/$code/input_validation.log");

    $kmer_length = escapeshellarg($_POST["kmer_length"]);
    $read_length = escapeshellarg($_POST["read_length"]);
    $max_kmer_cov = escapeshellarg($_POST["max_kmer_cov"]);
    $description = escapeshellarg($_POST["description"]);

    echo shell_exec("echo $description > user_data/$code/description.txt");

    $url="analysis.php?code=$code";
    $filename="user_uploads/$code";
    $oldmask = umask(0);
    mkdir("user_data/$code");
    umask($oldmask);

    // For old version:
    // echo shell_exec("Rscript histfitdup_bothplots.R $filename $kmer_length $read_length user_data/$code &> user_data/$code/errors.log &"); 
    
    // For new version:
    // genomescope.R histogram_file k-mer_length read_length output_dir
    echo shell_exec("Rscript genomescope.R $filename $kmer_length $read_length user_data/$code $max_kmer_cov &> user_data/$code/run.log &"); 

    header('Location: '.$url);
?>
    </body>
</html>

<!-- <form name="input_code_form" action="run.php" id="analysis_form" method="post"> -->
