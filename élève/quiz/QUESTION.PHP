<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="QUESTION.css">
    <link rel="icon" type="image/png" href="examicone.png">
    <title> QUESTION </title>
</head>
<body> 
    <div class="app">
        <h1> <?php echo$_GET['subject'];?> exam</h1>
        <div id="sco">scor</div>
        <div id="timer"></div>
        <div class="quiz">
            <h2 id="question">question goes here</h2>
            <div id="answer-buttons">
              <button class="btn">answr 1</button> 
              <button class="btn">answr 2</button> 
              <button class="btn">answr 3</button> 
              <button class="btn">answr 4</button>  
         </div>
            <button id="next-btn">Next</button>
        </div>
    </div>
    <div class="end">Made with ❤️ by Z.A.Y.O</div>
    <script src="QUESTION.js"></script>
</body>
</html>