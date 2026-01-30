document.addEventListener("DOMContentLoaded", () => {
  //handle ajax for delete user and task
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("delete-btn")) {
      const userId = e.target.dataset.id;

      if (!confirm("Are you sure?")) return;

      fetch(BASE_URL + "public/delete-user.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${userId}&csrf_token=${CSRF_TOKEN}`,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            e.target.closest("tr").remove();
          } else {
            alert(data.message);
          }
        });
    } else if (e.target.classList.contains("delete-task-btn")) {
      const taskId = e.target.dataset.id;
      console.log(taskId);
      if (!confirm("Are you sure?")) return;

      fetch(BASE_URL + "public/delete-task.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${taskId}&csrf_token=${CSRF_TOKEN}`,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            e.target.closest("tr").remove();
          } else {
            alert(data.message);
          }
        });
    }
  });

  // handler for menu
  const menu = document.querySelector(".menu_content");
  const openBtn = document.querySelector(".menu");
  const closeBtn = document.querySelector(".btn-close");
  const links = document.querySelectorAll(".nav-link");

  function handleOpenMenu() {
    menu.style.display = "block";
  }
  function handleCloseMenu() {
    menu.style.display = "none";
  }
  closeBtn.addEventListener("click", handleCloseMenu);
  openBtn.addEventListener("click", handleOpenMenu);
  links.forEach((l) => {
    l.addEventListener("click", handleCloseMenu);
  });
});
