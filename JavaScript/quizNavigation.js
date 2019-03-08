function navigation() {
    
    // class variables
    
    hiddenClass = 'hidden';
    visibleClass = 'visible';
    
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
    }
    
    // get DOM objects
    
    questions = document.getElementsByClassName('tblQuestions');
    if (!questions) {return;}
    previousAndNextBtns = document.getElementById('trQuestionButtons');
    previousBtn = document.getElementById('tdQuestionPrevious');
    nextBtn = document.getElementById('tdQuestionNext');
    tblBtns = document.getElementById('tblQuestionsButtons');
    reviewAnswersBtn = document.getElementById('trReviewAnswers');
    submitBtn = document.getElementById('trQuestionSubmit');
    
    // set reviewAnswers and submit button classes to hidden to start out with
    
    reviewAnswersBtn.className;
    submitBtn.className;
    
    // add event listeners to buttons
    
    previousBtn.onclick = function() {
        goToPreviousPage();
    }
    
    nextBtn.onclick = function() {
        goToNextPage();
    }
    
    reviewAnswersBtn.onclick = function() {
        reviewAnswers();
    }
    
    submitBtn.onclick = function() {
        getResults();
    }
    
    // other variables and counters
    
    removedQuestions = new Array();
    length = questions.length + 1;
    currentQuestion = 1;   
    answers = new Array();
    
    // iterate through questions to remove all questions to start out with
    
    for (i=1; i<length; i++) {
        
        // get question
        
        questionId = 'tblQuestion' + i;
        question = document.getElementById(questionId);
        
        // add question to removed questions array (for use later)
        
        removedQuestions[i] = question;
        
        // remove question
        
        if (i > 1) {
            question.parentNode.removeChild(question);
        }
    }
    
    toggleBtnVisibility();
    
    function goToPreviousPage() {
        
        getAnswerValues();
        
        form = document.getElementById('frmQuestions');
        question = form.firstChild;
        currentQuestion--;
        question.parentNode.replaceChild(removedQuestions[currentQuestion], question);
        toggleBtnVisibility();
    }
    
    function goToNextPage() {
        
        getAnswerValues();
        
        form = document.getElementById('frmQuestions');
        question = form.firstChild;
        currentQuestion++;
        question.parentNode.replaceChild(removedQuestions[currentQuestion], question);
        toggleBtnVisibility();
    }
    
    function reviewAnswers() {
        
        // get answers from last question
        
        getAnswerValues();
        
        // remove last question from form
        
        form = document.getElementById('frmQuestions');
        question = form.firstChild;
        question.parentNode.removeChild(question);
        
        // remove buttons from form
        
        tblBtns.parentNode.removeChild(tblBtns);
        previousBtn.className = hiddenClass;
        nextBtn.className = hiddenClass;
        reviewAnswersBtn.className = hiddenClass;
        
        // add all questions to the form
        
        for (i=1; i<length; i++) {
            form.appendChild(removedQuestions[i]);
        }
        
        // re-append submit button
        
        form.appendChild(tblBtns);
        submitBtn.className = visibleClass;
        
        // get selected answers
        
        questionAnswers = document.getElementsByClassName('trAnswers');
        answersLength = questionAnswers.length + 1;
        questionNum = 1;
        answerNum = 1;
        
        // iterated through answers and check radio buttons as needed
            
        for(i=1; i< answersLength; i++) {
            
            answerID = 'radQuestion' + questionNum + 'Answer' + answerNum;
            questionAnswer = document.getElementById(answerID);
            
            if (answers[questionNum][0] === answerNum) {
                questionAnswer.checked = true;
            } else {
                questionAnswer.checked = false;
            }
            
            if (answers[questionNum][1] === answerNum) {
                questionNum++;
                answerNum = 1;
                continue;
            }
            
            answerNum++;
        }  
    }
    
    // toggle button visibility function
    
    function toggleBtnVisibility() {
        if (currentQuestion === 1) {
            previousBtn.className = hiddenClass;
            nextBtn.className = visibleClass;
            reviewAnswersBtn.className = hiddenClass;
            submitBtn.className = hiddenClass;
        } else if (currentQuestion > 1 && currentQuestion < length - 1) {
            previousBtn.className = visibleClass;
            nextBtn.className = visibleClass;
        } else if (currentQuestion === length - 1) {
            previousBtn.className = visibleClass;
            nextBtn.className = hiddenClass;
            reviewAnswersBtn.className = visibleClass;
        }
    }
    
    // get answer values function for adding user selections to answers array
    
    function getAnswerValues() {
        
        // get answers elements and properties
        
        formAnswers = document.getElementsByClassName('trAnswers');
        formAnswersLength = formAnswers.length + 1;
        
        // iterate through radio button selections to get answer
        
        for (i=1; i<formAnswersLength; i++) {
            
            answerId = 'radQuestion' + currentQuestion + 'Answer' + i;
            answer = document.getElementById(answerId);
            
            if (answer.checked) {
                answers[currentQuestion] = new Array(i, formAnswersLength-1);
            }
        }
        
        if (!answers[currentQuestion]) {
            answers[currentQuestion] = (0, formAnswersLength-1);
        }
    }
    
    // function to get quiz results 
    
    function getResults() {
        
        // get input values
        
        answersInput = document.getElementsByClassName('inAnswers');
        if(!answersInput) {return;}
        answersInputLength = answersInput.length;
        
        // initialize score
        
        score = 0;
        
        // calculate score
        
        for (i=0; i<answersInputLength; i++) {
            if (answersInput[i].checked) {
                score += Number(answersInput[i].getAttribute('value'));
            } 
        }
        
        // calculate final score
        
        finalScore = Math.round((score / (length-1)) * 100);
        
        // assign image cookies
        
        if (finalScore <= 50) {
            document.cookie = "imgSrc = " + directory + "/Media/fail.png";
            document.cookie = "width = 350";
            document.cookie = "height = 310";
        } else if (finalScore > 50 && finalScore < 80) {
            document.cookie = "imgSrc = " + directory + "/Media/shrug.png";
            document.cookie = "width = 250";
            document.cookie = "height = 350";
        } else {
            document.cookie = "imgSrc = " + directory + "/Media/good-job.png";
            document.cookie = "width = 350";
            document.cookie = "height = 300";
        }
        
        // assign final score to cookie 
        
        document.cookie = "finalScore = " + finalScore;
    }
}

document.addEventListener("DOMContentLoaded", navigation, false);