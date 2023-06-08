const questions = [
    {
        question: "Which is the largest animal in the world?",
        answers: [
            { text: "Shark", correct: false },
            { text: "Elephant", correct: false },
            { text: "Blue whale", correct: true },
            { text: "Giraffe", correct: false },
        ]
    },
    {
        question: "Another question",
        answers: [
            { text: "Answer 1", correct: false },
            { text: "Answer 2", correct: true },
            { text: "Answer 3", correct: false },
            { text: "Answer 4", correct: false },
        ]
    },
    // Add more questions here
];

const questionElement = document.getElementById("question");
const answerButton = document.getElementById("answer-buttons");
const nextButton = document.getElementById("next-btn");
const scoree = document.getElementById("sco");
const timerElement = document.getElementById("timer");
//-------------------------------------------------------------------------------------------------------------------------
let currentQuestionIndex = 0;
let score = 0;
let timer;
//-------------------------------------------------------------------------------------------------------------------------
function showQuestion() {
    resetState(); 
    clearInterval(timer);
    timerElement.textContent = "40s";
    timer = startTimer();   
    let currentQuestion = questions[currentQuestionIndex];
    let questionNo = currentQuestionIndex + 1;
    let scor=document.createElement("h2")
    questionElement.innerHTML = questionNo + ". " + currentQuestion.question;
    scor.innerHTML = `${score} / ${questions.length}`;
    scor.classList.add("scor");
    scoree.innerHTML = ""; // Efface le contenu précédent avant d'ajouter le nouveau score
    scoree.appendChild(scor);
    currentQuestion.answers.forEach(answer => {
        const button = document.createElement("button");
        button.innerHTML = answer.text;
        button.classList.add("btn");
        answerButton.appendChild(button);
        if(answer.correct)
        {
            button.dataset.correct=answer.correct;
        }
        button.addEventListener("click",selectAnswer);
    });
}

function startQuiz() {
    currentQuestionIndex = 0;
    score = 0;
    nextButton.innerHTML = "Next";
    showQuestion();
}
function resetState()
{
    clearInterval(timer);
    nextButton.style.display="none";
    while(answerButton.firstChild)
    {
        answerButton.removeChild(answerButton.firstChild);           
    }
}
function selectAnswer(e)
{
    const selectBtn=e.target;
    const isCorrect=selectBtn.dataset.correct==="true";
    if(isCorrect)
    {
        selectBtn.classList.add("correct");
        score++;
    }
    else{
        selectBtn.classList.add("incorrect");
    }
    Array.from(answerButton.children).forEach(button => {
        if(button.dataset.correct==="true")
        {
            button.classList.add("correct");
        }
        button.disabled=true;
    });
    clearInterval(timer);
    nextButton.style.display="block "
}
function showScore() {
    resetState();
    questionElement.innerHTML = `You scored ${score} out of ${questions.length}!`;
    nextButton.innerHTML = "Play again";
    nextButton.style.display = "block";
     // Vérifie si c'est la dernière étape où le score s'affiche
     if (currentQuestionIndex === questions.length) {
        scoree.style.display = "none"; // Masque l'élément du score
        timerElement.style.display = "none";
    }
}
function handleNextButton()
{
    currentQuestionIndex++;
    if(currentQuestionIndex<questions.length)
    {
        showQuestion();
    }
    else
    {
        showScore();
    }
}
function startTimer() {
    let timeLeft = 30;
    timerElement.textContent = timeLeft + "s";

    const timer = setInterval(() => {
        timeLeft--;
        timerElement.textContent = timeLeft + "s";

        if (timeLeft === 0) {
            clearInterval(timer);
            handleNextButton();
        }
    }, 1000);

    return timer;
}
//-------------------------------------------------------------------------------------------------------------------------
nextButton.addEventListener("click", () => {
    if (currentQuestionIndex < questions.length) {
        handleNextButton();
    } else {
        startQuiz(); 
    }
});
startQuiz();