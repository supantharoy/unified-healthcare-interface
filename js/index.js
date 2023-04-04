
// ------------------------------- Typing Effect --------------------------------------

var typed = new Typed(".auto-type", {
  strings: [
    "Unified Healthcare Interface",
    "Unified Portal for Doctors",
    "Unified Portal for Patients",
    "Unified Portal for Everyone",
  ],
  typeSpeed: 50,
  backSpeed: 50,
  loop: true,
});

// ------------------------- Counter Up Animation ---------------------------------------

let section_counter = document.querySelector("#counter-section");
let counters = document.querySelectorAll(".counter-item .counter");

// Scroll Animation

let CounterObserver = new IntersectionObserver((entries, observer) => {
  let [entry] = entries;
  if (!entry.isIntersecting) return;

  let speed = 50;
  counters.forEach((counter, index) => {
    function UpdateCounter() {
      const targetNumber = +counter.dataset.target;
      const initialNumber = +counter.innerText;
      const incPerCount = targetNumber / speed;
      if (initialNumber < targetNumber) {
        counter.innerText = Math.ceil(initialNumber + incPerCount);
        setTimeout(UpdateCounter, 40);
      }
    }
    UpdateCounter();
  });
  observer.unobserve(section_counter);
});

CounterObserver.observe(section_counter);


// -------------------- Arrow Scroll to Top Button ---------------------

const arrow = document.getElementById("arrow");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    console.log(document.body.scrollTop)
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    arrow.style.display = "block";
  } else {
    arrow.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

arrow.addEventListener('click', topFunction)