const hallA_Btn = document.getElementById('hallA_Btn');
const hallB_Btn = document.getElementById('hallB_Btn');
const hallC_Btn = document.getElementById('hallC_Btn');
const hallD_Btn = document.getElementById('hallD_Btn');
const hallE_Btn = document.getElementById('hallE_Btn');


function hallBio() {
    hallA_Btn.addEventListener('click', () => {
        window.location.href = '../view/hallA.html';
    });

    hallB_Btn.addEventListener('click', () => {
        window.location.href = '../view/hallB.html';
    });
    
    hallC_Btn.addEventListener('click', () => {
        window.location.href = '../view/hallC.html';
    });
    
    hallD_Btn.addEventListener('click', () => {
        window.location.href = '../view/hallD.html';
    });
    
    hallE_Btn.addEventListener('click', () => {
        window.location.href = '../view/hallE.html';
    });



}
