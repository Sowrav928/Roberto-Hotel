let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const slidesContainer = document.querySelector('.slides');
const totalSlides = slides.length;

// Slow Slider
function showSlide(index) {
  currentSlide = (index + totalSlides) % totalSlides; // Handle wrap-around
  slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
}

//Navigation
function nextSlide() {
  showSlide(currentSlide + 1);
}

function prevSlide() {
  showSlide(currentSlide - 1);
}

// Auto-slide 
let autoSlide = setInterval(nextSlide, 100000);

// Stop auto-slide 
function resetAutoSlide() {
  clearInterval(autoSlide);
  autoSlide = setInterval(nextSlide, 5000);
}

// Add touch/swipe functionality
let startX = 0;
slidesContainer.addEventListener('touchstart', (e) => {
  startX = e.touches[0].clientX;
});

slidesContainer.addEventListener('touchend', (e) => {
  const endX = e.changedTouches[0].clientX;
  const diffX = endX - startX;
  
  if (Math.abs(diffX) > 50) {
    resetAutoSlide();
    if (diffX > 0) {
      prevSlide(); 
    } else {
      nextSlide();
    }
  }
});