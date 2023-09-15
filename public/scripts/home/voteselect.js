let vote_click = document.querySelectorAll("button[action='voteClick']")
let vote_status = document.getElementById("vote-status");

/**
 * 
 * @param {MouseEvent} e 
 */
function voteClick(e) {
    e.preventDefault();



    vote_status.style.animation = "expand-fadein 0.3s forwards";
    document.body.style.overflow = "hidden";

}

for (let button of vote_click) {
    button.addEventListener("click", voteClick);
}