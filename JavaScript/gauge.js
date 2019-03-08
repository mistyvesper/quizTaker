// https://geeksretreat.wordpress.com/2012/04/13/making-a-speedometer-using-html5s-canvas/

function drawGauge() {
    
    // class variables
    
    hiddenClass = 'hidden';
    quizzesClass = 'quizzes';
    
    // get directory 
    
    filePath = window.location.pathname;
    directory = filePath.substring(0, filePath.indexOf('/', 1));
    if (directory.indexOf('.php') > 0) {
        directory = '';
    } 
    
    // get score elements
    
    var scoreElement = document.getElementById('lblAverageScore');
    if(!scoreElement) {return;}
    var scoreText = scoreElement.innerText;
    scoreElement.className = hiddenClass;
    var score = scoreText.substring(0, scoreText.indexOf("%"));
    
    // get header elements and set header image
    
    var span = document.getElementById('spnLoggedIn');
    if(!span) {return;}
    if (score >= 0 && score <= 50) {
        span.style.backgroundImage = "url('" + directory + "/Media/header-red.jpg')";
    } else if (score > 50 && score < 80) {
        span.style.backgroundImage = "url('" + directory + "/Media/header-yellow.png')";
    } else if (score >= 80 && score <= 100) {
        span.style.backgroundImage = "url('" + directory + "/Media/header-green.jpg')";
    } else {
        span.style.backgroundImage = "url('" + directory + "/Media/header-gray.jpg')";
        scoreElement.className = quizzesClass;
        scoreElement.innerText = 'N/A';
        return;
    }
    
    // get canvas elements
    
    var canvas = document.getElementById('cnvAverageScore');
    if (!canvas) {return;}
    canvas.className = quizzesClass;
    var context = canvas.getContext('2d');
    
    // Canvas good?
    
    if (canvas.getContext) {
        drawArcs();
        drawPercentage();
    }
    else {
        scoreText.className = quizzesClass;
        canvas.className = hiddenClass;
    }
    
    // function to draw all arcs
    
    function drawArcs()
    {
        drawBackgroundArc();
        drawMiddlegroundArc();
        drawForegroundArc();
    }
    
    // function to draw background arc
    
    function drawBackgroundArc()
    {
        context.beginPath();

        // set fillStyle according to score
        
        if (score <= 50) {
            context.fillStyle = '#c3090a';
        } else if (score > 50 && score < 80) {
            context.fillStyle = '#fedb07';
        } else {
            context.fillStyle = 'green';
        }
        
        // draw the arc
        
        context.arc(120,120,120,1*Math.PI,0);

        // fill the arc
        
        context.fill();
        
        // set stroke
        
        context.strokeStyle = "white";
        context.stroke();
    }
    
    // function to draw the middle arc
    
    function drawMiddlegroundArc() {
        
        context.beginPath();
        
        // set fill style
        
        context.fillStyle = "rgb(242, 242, 242)";
        
        // calculate start and end angles
        
        if (score === 100) {
            startAngle = 0;
        } else {
            startAngle = (1 + (score/100));
        }
        
        endAngle = (startAngle + 1);
        
        // draw the arc
        
        context.arc(120, 120, 120, startAngle*Math.PI, endAngle*Math.PI);
        
        // fill the arc
        
        context.fill();
        
        // set stroke
        
        context.strokeStyle = "white";
        context.stroke();
    }
    
    // function to draw the foreground arc
    
    function drawForegroundArc()
    {

        context.beginPath();

        // set the fill style
        
        context.fillStyle = "white";
        
        // draw the arc
        
        context.arc(120,120,90,1*Math.PI,0);

        // fill the arc

        context.fill();
        
        // set stroke
        
        context.strokeStyle = "white";
        context.stroke();
    }
    
    // function to draw the percentage
    
    function drawPercentage() {
        context.font = "35px Times";
        context.fillStyle = "black";
        context.textAlign = "center";
        context.fillText(scoreText, 120, 100);
    }
    
}

document.addEventListener("DOMContentLoaded", drawGauge, false);