const home = document.querySelector(".home"),
  user = document.querySelector(".user"),
  balance = document.querySelector(".balance"),
  settings = document.querySelector(".settings");

const content1 = document.querySelector(".content1"),
  content2 = document.querySelector(".content2"),
  content3 = document.querySelector(".content3"),
  content4 = document.querySelector(".content4");

function hideAllSections() {
  content1.classList.remove("active");
  content2.classList.remove("active");
  content3.classList.remove("active");
  content4.classList.remove("active");
}

home.addEventListener("click", () => {
  hideAllSections();
  content1.classList.add("active");
});

user.addEventListener("click", () => {
  hideAllSections();
  content2.classList.add("active");
});

balance.addEventListener("click", () => {
  hideAllSections();
  content3.classList.add("active");
});

settings.addEventListener("click", () => {
  hideAllSections();
  content4.classList.add("active");
});
