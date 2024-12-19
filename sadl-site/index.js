//form error handling
function validateForm() {
  // need to access the name field
  const name = document.getElementById("name").value;
  if (name === "") {
    console.log("Please add your name");
  }
}

validateForm();
// nav item refresh issue
