import * as model from "./model.js";

// register event hiding the user menu (if menu is collapsed) on clicking outside the user menu
function eventClickedInBody() {
  document.body.addEventListener('click', (evt) => {
    const clicked_element = evt.target;
    // if clicked within the user menu element then do nothing
    if(document.getElementById('user-menu').contains(clicked_element)) return;
    // else, if user menu visible, hide the menu 
    if(document.getElementById('user-menu').classList.contains('show')) {
      document.getElementById('user-menu').classList.remove("show");
    }
  });
}

// add event on logout user
document.getElementById('logout-btn').addEventListener('click', async (evt) => {
  evt.preventDefault();
  await fetch("../sql_api.php?q=logout");
  location.href="../main.php";
});

// register event hiding the user menu (if menu is collapsed) on clicking outside the user menu
eventClickedInBody();
