let vote_select = document.querySelectorAll("button[action='voteClick']")
let vote_status = document.getElementById("vote-status");

/**
 * 
 * @param {MouseEvent} e 
 */
function voteClick(e) {
    e.preventDefault();
    console.log("vptew");

    vote_status.style.animation = "expand-fadein 0.3s forwards";
    document.body.style.overflow = "hidden";
}

for (let button of vote_select) {
    console.log(button)
    button.addEventListener("click", voteClick);
}