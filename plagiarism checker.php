


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text1 = strtolower($_POST['text1']);
    $text2 = strtolower($_POST['text2']);

    $words1 = explode(' ', $text1);
    $words2 = explode(' ', $text2);

    $uniqueWords1 = array_unique($words1);
    $uniqueWords2 = array_unique($words2);

    $wordCount1 = count($uniqueWords1);
    $wordCount2 = count($uniqueWords2);

    // Calculate similarity percentage
    $duplicatedWords = findDuplicatedWords($uniqueWords1, $uniqueWords2);
    $similarityPercentage = calculateSimilarityPercentage($duplicatedWords, $wordCount1, $wordCount2);

    // Highlight and underline duplicated words
    $text1Highlighted = highlightDuplicatedWords($text1, $duplicatedWords);
    $text2Highlighted = highlightDuplicatedWords($text2, $duplicatedWords);

    echo "<h3>Results:</h3>";
    echo "Text 1 Word Count: $wordCount1<br>";
    echo "Text 1 Character Count: " . strlen($text1) . "<br>";
    echo "<br>";
    echo "Text 2 Word Count: $wordCount2<br>";
    echo "Text 2 Character Count: " . strlen($text2) . "<br>";
    echo "<br>";
    $round=  round($similarityPercentage, 2);
    if( $round>60){
      echo "<b><span style='color:red'>Similarity Percentage: " . $round . "% </span></b>";
    }else if( $round==0){
    echo "<b><h2 style='color:green '>Similarity Percentage: " . $round . "% </h2></b>";
    }else{
    echo "<b></h2>Similarity Percentage: " . $round . "%</h2></b>"; 
    }
    echo "<br><br>";
    echo "Text 1 with Duplicated Words Highlighted and Underlined:<br>";
    echo "<pre>$text1Highlighted</pre>";
    echo "<br>";
    echo "Text 2 with Duplicated Words Highlighted and Underlined:<br>";
    echo "<pre>$text2Highlighted</pre>";
}

function findDuplicatedWords($words1, $words2) {
    $duplicatedWords = array_intersect($words1, $words2);
    return $duplicatedWords;
}

function calculateSimilarityPercentage($duplicatedWords, $wordCount1, $wordCount2) {
    $totalDuplicatedWords = count($duplicatedWords);
    $totalUniqueWords = max($wordCount1, $wordCount2);
    $similarityPercentage = ($totalDuplicatedWords / $totalUniqueWords) * 100;
    return $similarityPercentage;
}

function highlightDuplicatedWords($text, $duplicatedWords) {
    foreach ($duplicatedWords as $word) {
        $text = preg_replace("/\b$word\b/i", '<strong><u>$0</u></strong>', $text);
    }
    return $text;
}


?>






<!DOCTYPE html>
<html>
<head>
  <title>Plagiarism Checker</title>
</head>
<body>
  <h2>Plagiarism Checker</h2>
  <form action="check.php" method="post">
    <label for="text1">Text 1:</label><br>
    <textarea name="text1" id="text1" rows="4" cols="50"></textarea><br>
    <label for="text2">Text 2:</label><br>
    <textarea name="text2" id="text2" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Check Plagiarism">
  </form>
</body>
</html>
