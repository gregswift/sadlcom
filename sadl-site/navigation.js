document.addEventListener("DOMContentLoaded", () => {
  fetch("../navigation.html")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Failed to load navbar: ${response.statusText}`);
      }
      return response.text();
    })
    .then((data) => {
      document.getElementById("site-header").innerHTML = data;
    })
    .catch((error) => {
      console.error(error);
    });
});
